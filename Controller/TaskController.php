<?php

namespace App\Controller;

use App\Model\Task;
use App\Core\Request;

class TaskController{

    public static function index(){
        $tasks = Task::all();
        return $tasks;
    }

    public static function show($taskId){
        $task = Task::find($taskId);
        return $task;
    }


    public static function store(){
        $request = new Request();
        $data = $request->getData();
        $task = new Task();
        $task->title = $data['title'];
        $task->description = $data['description'];
        $task->end_date = $data['end_date'];
        $task->userId = $data['userId'];
        $task->status = $data['status'];
        Task::save($task);
    }

    public static function update($taskId){
        $task = Task::find($taskId);
        return $task;
    }

    public static function destroy($taskId){
        Task::delete($taskId);
    }

    public static function columns(){
        // $columns = Task::save();
        // return $columns;
        echo 'valami';
    }

}