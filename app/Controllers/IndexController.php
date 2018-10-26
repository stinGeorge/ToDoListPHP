<?php

namespace App\Controllers;
use App\Models\Task;

class IndexController extends BaseController {
    public function indexAction(){
        return $this->renderHTML('index.twig');
    }
}