<?php

namespace App\Controllers;
use App\Models\Task;

class TaskController extends BaseController{
    public function addAction($request){
        if($request->getMethod() === 'POST'){
            $postData = $request->getParsedBody();
            $task = new Task();
            $task->name = $postData['name'];
            $task->save();
        }

        echo $this->renderHTML('addTask.twig');
    }
}