<?php

class App
{
    public static $app;
    private $__controller, $__routes;
    private $__action = 'index';
    private $__params = [];
    private $__db;
    private $__request;

    public function __construct()
    {
        global $routes;
        self::$app = $this;
        $this->__routes = new Router();
        $this->__controller = $routes['default_controller'] ?? "home";
        $dbOb = new DB();
        $this->__db = $dbOb->db;
        $this->handleUrl();
    }

    public function getUrl()
    {
        if (isset($_SERVER['PATH_INFO'])) {
            $url = $_SERVER['PATH_INFO'];
        } else {
            $url = '/';
        }
        return $url;
    }

    public function handleUrl()
    {
        $url = $this->getUrl();
        $url = $this->__routes->handleRoute($url);
        //Middleware app;
        $this->handleGlobalMiddware(trim($this->getUrl(),'/'), $this->__db);
        $this->handleRouteMiddleware($this->__routes->getKeyRoute(), $this->__db);

        $urlArr = array_filter(explode('/', $url));
        $urlArr = array_values($urlArr);

        $urlCheck = '';
        foreach ($urlArr as $key => $item) {
            $urlCheck = strtolower($urlCheck) . ucfirst($item) . '/';
            $fileCheck = rtrim($urlCheck, '/');
            if (!empty($urlArr[$key - 1])) {
                unset($urlArr[$key - 1]);
            }
            if (file_exists("app/controllers/${fileCheck}Controller.php")) {
                $urlCheck = $fileCheck;
                break;
            }
        }
        $urlArr = array_values($urlArr);
        if (isset($urlArr[0])) {
            $this->__controller = ucfirst($urlArr[0]) . "Controller";
            unset($urlArr[0]);
        } else {
            $this->__controller = ucfirst($this->__controller) . "Controller";
        }
        if (file_exists("app/controllers/" . $urlCheck . "Controller.php")) {
            require_once "controllers/" . $urlCheck . "Controller.php";
            $this->__controller = new $this->__controller();
            $this->__controller->db = $this->__db;
        } else {
            $this->loadError();
        }
        if (isset($urlArr[1])) {
            if (method_exists($this->__controller, $urlArr[1])) {
                $this->__action = $urlArr[1];
                unset($urlArr[1]);
            }
        }
        $this->__params = array_values($urlArr);

        call_user_func_array([$this->__controller, $this->__action], $this->__params);
    }

    public function loadError($errorType = '404', $data = [])
    {
        extract($data);
        require_once "errors/$errorType.php";
    }

    private function handleRouteMiddleware($routeKey, $db)
    {
        $routeKey = trim($routeKey);
        global $config;
        if (isset($config['app']['routeMiddlware'])) {
            $routeMiddlewares = $config['app']['routeMiddlware'];
            if (!empty($routeMiddlewares)) {
                foreach ($routeMiddlewares as $key => $middlewareItem) {
                    if ($routeKey === trim($key) && file_exists("app/middlewares/$middlewareItem.php")) {
                        require_once "app/middlewares/$middlewareItem.php";
                        if (class_exists($middlewareItem)) {
                            $middlewareObj = new $middlewareItem($db);
                            $middlewareObj->handle();
                        }
                    }
                }
            }
        }
    }

    private function handleGlobalMiddware($uri, $db)
    {
        global $config;
        if (isset($config['app']['globalMiddleware'])) {
            $globalMiddlewares = $config['app']['globalMiddleware'];
            if (!empty($globalMiddlewares)) {
                foreach ($globalMiddlewares as $key => $middlewareItem) {
                    if (file_exists("app/middlewares/$middlewareItem.php")) {
                        require_once "app/middlewares/$middlewareItem.php";
                        if (class_exists($middlewareItem)) {
                            $middlewareObj = new $middlewareItem($db);
                            $middlewareObj->handle($uri);
                        }
                    }
                }
            }
        }
    }
}