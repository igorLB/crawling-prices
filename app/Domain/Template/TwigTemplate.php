<?php 

namespace App\Domain\Template;

use App\Core\AbstractTemplate;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigTemplate extends AbstractTemplate{
    /** @var FilesystemLoader */
    protected $loader;
    /** @var Environment */
    protected $twig;
    /** @var string */
    protected $basetemplate = __DIR__ . '/../../Resources/Layout';

    public function __construct()
    {
        $loader = new FilesystemLoader($this->basetemplate);
        $this->loader = $loader;
        $twig = new Environment($loader);
        $this->twig = $twig;
    }


    public function renderView(string $viewName, array $data) 
    {
        $baseUrl = __DIR__ . '/../../../';

        echo $this->twig->render($viewName . '.html.twig', array_merge([
            'base_url' => $baseUrl
        ], $data));
    }


}