<?php

namespace App\Core;

use App\Domain\Template\TwigTemplate;
use App\Core\AbstractTemplate;

abstract class BaseController {

    /** @var AbstractTemplate */
    protected $template;

    public function __construct()
    {
        $this->template = new TwigTemplate();
    }


}