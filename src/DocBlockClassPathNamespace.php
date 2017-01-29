<?php

namespace DocBlockRoute;


class DocBlockClassPathNamespace
{
    /**
     * @var string
     */
    public $namespace;
    /**
     * @var string
     */
    public $classPath;

    /**
     * DocBlockClassPathNamespace constructor.
     * @param string $namespace
     * @param string $classPath
     */
    public function __construct($namespace, $classPath)
    {
        $this->classPath = $classPath;
        $this->namespace = $namespace;
    }
}
