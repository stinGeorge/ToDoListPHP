<?php

namespace App\Controllers;
use App\Models\Task;

class IndexController{
    public function indexAction(){
        $tasks = Task::all();
        include_once '../app/Views/index.php';
    }
}