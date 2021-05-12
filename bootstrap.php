<?php
define("__DIR_ROOT__", __DIR__);
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
    $webRoot = 'https://' . $_SERVER['HTTP_HOST'];
} else {
    $webRoot = 'http://' . $_SERVER['HTTP_HOST'];
}
$folder = str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR_ROOT__);
define(__WEB_ROOT, $webRoot . $folder);

$config_dir = scandir('configs');
if (!empty($config_dir)) {
    foreach ($config_dir as $item) {
        if ($item !== '.' && $item !== '..' && file_exists("configs/$item")) {
            require_once "configs/$item";
        }
    }
}
//load all services
if (isset($config['app']['service'])){
    $allServices = $config['app']['service'];
    if (!empty($allServices)){
        foreach ($allServices as $serviceName){
            if (file_exists("app/core/$serviceName.php")){
                require_once "app/core/$serviceName.php";
            }
        }
    }
}
require_once 'core/Middleware.php';


require_once 'core/Router.php';
require_once "core/Session.php";
require_once 'app/App.php';
if (!empty($config['database'])){
    $db_config = /*array_filter($config['database'])*/ $config['database'];
    if (!empty($db_config)){
        require_once 'core/Connect.php';
        require_once "core/QueryBuilder.php";
        require_once 'core/Database.php';
        require_once 'core/DB.php';
    }
}
//load core Helper
require_once "core/Helper.php";
//load all helper
$allHelper = scandir('app/helpers');
if (!empty($allHelper)) {
    foreach ($allHelper as $item) {
        if ($item !== '.' && $item !== '..' && file_exists("app/helpers/$item")) {
            require_once "app/helpers/$item";
        }
    }
}
require_once 'core/Model.php';
require_once 'core/Controller.php';
require_once 'core/Request.php';
require_once 'core/Response.php';