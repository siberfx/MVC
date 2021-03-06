<?php

class app
{
    protected $controller = 'home';
    protected $method = 'index';
    protected $prams = [];

    public function __construct()
    {
        $url = $this->parseUrl();
        if($url === null || !isset($url[0])) {
            $url = ['home']; # home controlloer is the default
        }

        if (file_exists('../app/controllers' . $url[0] . '.php')) {
            $this->controller = $url[0];
            unset($url[0]);

        }
        require_once APP_PATH.DS.'controllers'. DS. $this->controller . '.php';

        $this->controller = new $this->controller;

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }

        }

        $this->prams = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->prams);
    }


    public function parseUrl()
    {
        if (isset($_GET['url'])) {
            return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}