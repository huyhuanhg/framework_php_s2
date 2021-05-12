<?php


class Router
{
    private $__keyRoute = null;

    public function __construct()
    {
    }

    public function handleRoute($url)
    {
        global $routes;
        unset($routes['default_controller']);
        $url = trim($url, '/');
        if (empty($url)) {
            $url = '/';
        }
        if (!empty($routes)) {
            foreach ($routes as $key => $value) {
                if (preg_match("~$key~is", $url)) {
                    $this->__keyRoute = $key;
                    return preg_replace("~$key~is", $value, $url);
                }
            }
        }
        return $url;
    }

    public function getKeyRoute()
    {
        return $this->__keyRoute;
    }

    public static function getFullUrl()
    {
        $uri = App::$app->getUrl();
        return __WEB_ROOT .$uri;
    }
}