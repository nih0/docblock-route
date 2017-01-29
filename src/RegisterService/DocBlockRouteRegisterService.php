<?php

namespace DocBlockRoute\RegisterService;

use DocBlockRoute\RouteCollection\AbstractRouteCollection;
use DocBlockRoute\DocBlockClassPathNamespace;
use phpDocumentor\Reflection\DocBlockFactory;
use DocBlockRoute\PathTag;

/**
 * Class DocBlockRouteRegisterService
 * @package DocBlockRoute
 */
class DocBlockRouteRegisterService extends RouteRegisterService
{
    /**
     * @var AbstractRouteCollection
     */
    protected $router;

    /**
     * DocBlockRouteRegisterService constructor.
     * @param AbstractRouteCollection $router
     */
    public function __construct(AbstractRouteCollection $router)
    {
        $this->router = $router;
    }

    /**
     * @param array $controllerPaths
     */
    public function register($controllerPaths)
    {
        foreach ($controllerPaths as $controllerPath) {
            $this->registerControllers($controllerPath);
        }
    }

    /**
     * @param DocBlockClassPathNamespace $dirPath
     */
    private function registerControllers($dirPath)
    {
        $factory = DocBlockFactory::createInstance();
        $factory->registerTagHandler('path', PathTag::class);
        foreach (scandir($dirPath->classPath) as $controllerFile) {
            if ($controllerFile != '.' && $controllerFile != '..') {
                $controllerSource = file_get_contents($dirPath->classPath . $controllerFile);
                $docBlock = $factory->create($controllerSource);
                foreach ($docBlock->getTagsByName('path') as $path) {
                    $info = $path->getPathInfo();
                    $controllerWithoutFileEnding = substr($controllerFile, 0, strrpos($controllerFile, '.php'));
                    $this->router->addRoute($info[0], $info[1], $dirPath->namespace, $info[2]);
                }
            }
        }
    }
}
