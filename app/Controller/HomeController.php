<?php

namespace App\Controller;

use App\Core\BaseController;
use CoffeeCode\Router\Router;
use GuzzleHttp\Client;
use Sunra\PhpSimple\HtmlDomParser;
use Symfony\Component\DomCrawler\Crawler;

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

        $resultMail = mail(
            'igorcedrolb@gmail.com',
            'Cappuccino price: ' . $result,
            "O preço do cappuccino hoje está: " . $result
        );

        var_dump($resultMail);
    }

}