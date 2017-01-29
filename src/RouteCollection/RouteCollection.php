<?php

namespace DocBlockRoute\RouteCollection;

class RouteCollection extends AbstractRouteCollection
{
    /**
     * @param string $method
     * @param string $path
     * @param string $controllerMethod
     * @param string $controllerNamespace
     */
    public function addRoute($method, $path, $controllerNamespace, $controllerMethod)
    {
        $pathWithBasePath = $this->basePath == null ? $path : $this->basePath . $path;
        $this->routes[$method][$pathWithBasePath] = [$controllerNamespace, $controllerMethod];
    }

    /**
     * @return string
     */
    private function getPath()
    {
        $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
        $parsed_url = parse_url($url);
        return $parsed_url['path'];
    }

    /**
     * @return bool
     */
    public function match()
    {
        $constructed_path = $this->getPath();
        $controller_namespace_method = $this->routes[$_SERVER['REQUEST_METHOD']][$constructed_path];
        if ($controller_namespace_method == null) {
            return false;
        }
        $this->doAction($controller_namespace_method[0], $controller_namespace_method[1]);
    }

    /**
     * @param string $controllerNamespace
     * @param string $controllerMethod
     */
    private function doAction($controllerNamespace, $controllerMethod)
    {
        $parts = explode('::', $controllerMethod);
        $constructed_class = $controllerNamespace . $parts[0];
        $instance = new $constructed_class();
        $methodStr = $parts[1];
        if ($instance != null) {
            echo $instance->$methodStr();
        }
    }
}
