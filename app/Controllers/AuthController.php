<?php

namespace App\Controllers;
use App\Models\User;

class AuthController extends BaseController {
    function indexAction(){
        return $this->renderHTML('loginForm.twig');
    }

    function authLogin($request){
        $postData = $request->getParsedBody();
        $user = User::where('email', $postData['email'])->first();

        if($user){
            if(password_verify($postData['password'], $user->password)){
                echo 'Success';
            }else{
                echo 'Wrong';
            }
        }else{
            echo 'Not Found';
        }
    }
}