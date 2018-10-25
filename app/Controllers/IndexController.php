<?php

namespace App\Controllers;
use App\Models\Task;

class IndexController extends BaseController {
    public function indexAction(){
        $tasks = Task::all();
        $data = array('tasks' => $tasks);
        return $this->renderHTML('index.twig', $data);
    }
}