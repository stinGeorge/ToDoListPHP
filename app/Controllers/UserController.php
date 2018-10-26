<?php

namespace App\Controllers;

use App\Models\User;
use Respect\Validation\Validator as v;

class UserController extends BaseController{
    function indexAction(){
        $users = User::all();
        $data = array('users' => $users);
        return $this->renderHTML('indexUser.twig', $data);
    }

    function addAction($request){
        $responseMessage = '';
        $statusMessage = 0;

        if($request->getMethod() === 'POST'){
            $postData = $request->getParsedBody();
            $userValidator = v::key('email', v::email()->notEmpty())->key('password', v::length(3, 8));

            try{
                $userValidator->assert($postData);

                $user = new User();
                $user->email = $postData['email'];
                $user->password = password_hash($postData['password'], PASSWORD_DEFAULT);
                $user->save();

                $responseMessage = 'Saved!!!';
                $statusMessage = 1;
            }catch (\Exception $e){
                $responseMessage = $e->getMessage();
                $statusMessage = -1;
            }
        }

        return $this->renderHTML('addUser.twig', array(
            'responseMessage' => $responseMessage,
            'statusMessage' => $statusMessage
        ));
    }
}