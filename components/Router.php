<?php

class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT.'/config/routes.php';
        $this->routes = include($routesPath);
    }

    /**
     * Return request string
     * @return string
     */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI']))
            return trim($_SERVER['REQUEST_URI'], '/');
    }

    public function run()
    {
        $uri = $this->getURI();

        foreach ($this->routes as $uriPattern => $path){

            if (preg_match("~$uriPattern~", $uri)) {

                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                $segments = explode('/', $internalRoute);

                $controllerName = ucfirst(array_shift($segments)) . "Controller";
                $actionName = 'action' . ucfirst(array_shift($segments));

                $controllerFileName = ROOT . '/controllers/' . $controllerName . '.php';

                if (file_exists($controllerFileName)) {
                    include_once($controllerFileName);
                }

                $controllerObject = new $controllerName;

                $parameters = $segments;
                $result = call_user_func_array(array($controllerObject,$actionName), $parameters);

                if ($result != NULL) {
                    break ;
                }
            }
        }

    }
}