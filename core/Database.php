<?php

class Database
{
    private $__conn;
    use QueryBuilder;
    public function __construct()
    {
        global $db_config;
        $this->__conn = Connect::getInstance($db_config)->connect;
    }
    public function query($sql){
        try{
            $stmt = $this->__conn->prepare($sql);
            $stmt->execute();
            return $stmt;
        } catch (Exception $e){
            $data['mess'] = $e->getMessage();
            App::$app->loadError('database', $data);
            die();
        }
    }
}