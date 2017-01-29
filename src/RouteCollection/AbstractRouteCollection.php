<?php

namespace DocBlockRoute\RouteCollection;


abstract class AbstractRouteCollection
{
    /**
     * @var array
     */
    protected $routes = [];
    /**
     * @var string
     */
    protected $basePath;

    /**
     * AbstractRouteCollection constructor.
     * @param string $basePath
     */
    public function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @param string $method
     * @param string $path
     * @param string $controllerMethod
     * @param string $controllerNamespace
     */
    abstract public function addRoute($method, $path, $controllerNamespace, $controllerMethod);

    abstract public function match();
}
