<?php

namespace App\Controller;

use App\Core\BaseController;
use CoffeeCode\Router\Router;
use GuzzleHttp\Client;
use Sunra\PhpSimple\HtmlDomParser;
use Symfony\Component\DomCrawler\Crawler;
use WeakMap;

class HomeController extends BaseController
{
    /** @var CoffeeCode\Router\Router */
    private $router;

    public function __construct($router)
    {
        parent::__construct();
        $this->router = $router;
    }


    public function index()
    {
        return $this->template->renderView('index', [
            'user' => 'Igor Cedro',
            'pagetitle' => 'cedrodev'
        ]);
    }

    public function suporte()
    {
        echo "NOSSO SUPORTE";
    }


    public function error($data)
    {
        echo "<h1>Erro{$data["errcode"]}</h1>";
        var_dump($data);
    }

    public function listar()
    {
        $con = $this->getCon();

        $sql = "SELECT * FROM promotions";
        $result = $con->query($sql);
        $promotions = $result->fetchAll(\PDO::FETCH_OBJ);

        return $this->template->renderView('listar', [
            'promotions' => $promotions
        ]);
    }

    public function crawling()
    {
        $url = "https://www.nescafe-dolcegusto.com.br/sabores/chocolate/capsulas-chococino";

        $client = new Client();
        $res = $client->request('GET', $url);
        $html = $res->getBody()->__toString();
    
        $crawler = new Crawler($html);

        $craw = $crawler->filter('span[data-price-type="finalPrice"]');

        $result = $craw->text();

        var_dump($result);

        $floatValue = (float)str_replace(',', '.', str_replace(['R','$'], '', $result));

        if ($this->insertResult('dolcegusto-caixa-chococino', $floatValue, $url)) {
            echo "<p>Inserido no banco</p>";
        }

        if ($floatValue < 20) {
            $resultMail = mail(
                'igorcedrolb@gmail.com',
                'Cappuccino price: ' . $result,
                "O preço do cappuccino hoje está: " . $result
            );
            echo "<p>Email enviado</p>";
            var_dump($resultMail);
        }    
    }


    private function insertResult($product, $price, $website)
    {
        $conn = $this->getCon();

        $sql = 'INSERT INTO promotions 
                (craw_date, product, price, website) 
                VALUES 
                (NOW(), :product, :price, :website);';
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':product', $product);
        $stmt->bindValue(':price', $price);
        $stmt->bindValue(':website', $website);
        
        try {
            return $stmt->execute();
        } catch (\Exception $e) {
            echo '<p style="color: red">' . $e->getMessage() . '</p>';
        }
    }


    private function getCon()
    {
        $host = "108.167.188.235";
        $dbname = "rendaj45_tests";
        $user = "rendaj45_igor";
        $pass = "56762056L@byor";

        $conn = new \PDO("mysql:host=${host};dbname=${dbname}", $user, $pass);
        $conn->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(\PDO::ATTR_ORACLE_NULLS,\PDO::NULL_EMPTY_STRING);

        return $conn;
    }
}