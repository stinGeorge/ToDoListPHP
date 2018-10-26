<?php

namespace App\Controllers;
use App\Models\Task;
use Respect\Validation\Validator as v;

class TaskController extends BaseController{
    public function indexAction(){
        $tasks = Task::all();
        $data = array('tasks' => $tasks);
        return $this->renderHTML('indexTask.twig', $data);
    }

    public function addAction($request){
        $responseMessage = '';
        $statusMessage = 0;
        if($request->getMethod() === 'POST'){
            $postData = $request->getParsedBody();
            $jobValidator = v::key('name', v::stringType()->notEmpty());

            try{
                $jobValidator->assert($postData);
                $task = new Task();
                $task->name = $postData['name'];

                $files = $request->getUploadedFiles();
                $image = $files['image'];
                if($image->getError() == UPLOAD_ERR_OK){
                    $fileName = $image->getClientFileName();
                    $image->moveTo("uploads/$fileName");
                    $task->image_name = $fileName;
                }

                $task->save();
                $responseMessage = 'Saved!!!';
                $statusMessage = 1;
            }catch (\Exception $e){
                $responseMessage = $e->getMessage();
                $statusMessage = -1;
            }
        }

        return $this->renderHTML('addTask.twig', array(
            'responseMessage' => $responseMessage,
            'statusMessage' => $statusMessage
        ));
    }
}