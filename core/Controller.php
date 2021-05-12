<?php


class Controller
{
    public $db;
    public function __construct()
    {
//        echo 'this is ctl';
    }

    public function model($model)
    {
        require_once __DIR_ROOT__ . "/app/models/" . $model . ".php";
        return new $model();
    }
    public function render($view, $data = []){
        extract($data);
        require_once __DIR_ROOT__ . "/app/views/" . $view . ".php";
    }
}