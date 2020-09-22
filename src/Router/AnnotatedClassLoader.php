<?php

namespace StageApp\Router;

use Illuminate\Support\Str;
use Symfony\Component\Routing\Route;

class AnnotatedClassLoader extends \Symfony\Component\Routing\Loader\AnnotationClassLoader
{
    /**
     * @param Route $route
     * @param \ReflectionClass $class
     * @param \ReflectionMethod $method
     * @param $annot
     */
    protected function configureRoute(Route $route, \ReflectionClass $class, \ReflectionMethod $method, $annot)
    {
        $route->setDefault('_controller', $class->getName());

        if ($method->getName() !== '__invoke') {
            $route->setDefault('_action', $method->getName());
        }
    }
}