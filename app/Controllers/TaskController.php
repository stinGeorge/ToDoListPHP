<?php

namespace App\Controllers;
use App\Models\Task;

class TaskController{
    public function addAction(){
        if(!empty($_POST)){
            $task = new Task();
            $task->name = $_POST['name'];
            $task->save();
        }
        include '../app/Views/addTask.php';
    }
}