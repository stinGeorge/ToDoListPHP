<?php

namespace App\Controllers;

class AuthController extends BaseController {
    function indexAction(){
        return $this->renderHTML('loginForm.twig');
    }
}