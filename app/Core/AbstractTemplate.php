<?php

namespace App\Core;


abstract class AbstractTemplate {

    abstract public function renderView(string $viewName, array $data);

}