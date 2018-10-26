<?php

namespace App\Controllers;
use App\Models\User;
use Zend\Diactoros\Response\RedirectResponse;

class AuthController extends BaseController {
    function indexAction(){
        return $this->renderHTML('loginForm.twig');
    }

    function authLogin($request){
        $responseMessage = 'The email o password is incorrect.';
        $statusMessage = -1;
        $postData = $request->getParsedBody();
        $user = User::where('email', $postData['email'])->first();

        if($user){
            if(password_verify($postData['password'], $user->password)){
                return new RedirectResponse('/projects/php/admin/');
            }
        }

        return $this->renderHTML('loginForm.twig', array(
            'responseMessage' => $responseMessage,
            'statusMessage' => $statusMessage
        ));
    }

    function indexAdmin(){
        return $this->renderHTML('admin.twig');
    }
}