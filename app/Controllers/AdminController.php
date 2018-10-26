<?php

namespace App\Controllers;

class AdminController extends BaseController{
    function index(){
        return $this->renderHTML('admin.twig');
    }
}