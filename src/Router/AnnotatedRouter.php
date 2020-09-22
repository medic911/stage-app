<?php

namespace StageApp\Router;

use Doctrine\Common\Annotations\AnnotationReader;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use StageApp\Http\Request;
use StageApp\Traits\Singleton;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Loader\AnnotationDirectoryLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class AnnotatedRouter
{
    use Singleton;

    /**
     * @var AnnotationDirectoryLoader
     */
    protected $loader;

    /**
     * @var RouteCollection
     */
    protected $routeCollection;

    /**
     * Router constructor.
     */
    private function __construct()
    {
        $this->loader = new AnnotationDirectoryLoader(
            new FileLocator,
            new AnnotatedClassLoader(new AnnotationReader)
        );
    }

    /**
     * @param string $controllersPath
     * @return $this
     */
    public function collectRoutes(string $controllersPath): self
    {
        $this->routeCollection = $this->loader->load($controllersPath);
        return $this;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function matchRequest(Request $request): array
    {
        $urlMatcher = new UrlMatcher($this->routeCollection, (new RequestContext)->fromRequest($request));
        $parameters = $urlMatcher->match($request->getPathInfoWithoutLocale());

        $callable = new $parameters['_controller'];
        if (array_key_exists('_action', $parameters)) {
            $callable = [$callable, $parameters['_action']];
        }

        $arguments = array_filter($parameters, function ($name) {
            return !Str::startsWith($name, '_');
        }, ARRAY_FILTER_USE_KEY);

        return [
            'callable' => $callable,
            'arguments' => array_values($arguments),
        ];
    }
}