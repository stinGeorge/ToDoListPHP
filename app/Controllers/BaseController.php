<?php

namespace App\Controllers;

class BaseController{
    protected $templateEngine;

    public function __construct(){
        $loader = new \Twig_Loader_FileSystem('../app/Views');
        $this->templateEngine = new \Twig_Environment($loader, array(
            'cache' => false,
            'debug' => true,
        ));
    }

    public function renderHTML($fileName, $data = []){
        return $this->templateEngine->render($fileName, $data);
    }
}