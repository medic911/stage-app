<?php

namespace StageApp;

use Illuminate\Support\Str;
use StageApp\Exceptions\RouteNotFoundException;
use StageApp\Http\Request;
use StageApp\Interfaces\RouterInterface;

class Router implements RouterInterface
{
    /**
     * @var string
     */
    protected $defaultAction = 'index';

    /**
     * @var string
     */
    protected $defaultController = 'IndexController';

    /**
     * @var string
     */
    protected $controllerNamespace;

    /**
     * @var string
     */
    protected $controller;

    /**
     * @var string
     */
    protected $action;

    /**
     * Router constructor.
     * @param string $controllerNamespace
     */
    public function __construct(string $controllerNamespace)
    {
        $this->controllerNamespace = $controllerNamespace;
    }

    /**
     * @param Request $request
     * @return array
     * @throws RouteNotFoundException
     */
    public function match(Request $request): array
    {
        $path = $this->preparePath($request->getSplittedPath());
        $this->matchFromPath($path);

        if (!class_exists($this->controller)) {
            throw new RouteNotFoundException("Route not found for {$request->getPath()}");
        }

        if (!is_callable([$this->controller, $this->action])) {
            throw new RouteNotFoundException("Route not found for {$request->getPath()}");
        }

        return [new $this->controller, $this->action];
    }

    /**
     * @param array $path
     * @return array
     */
    protected function preparePath(array $path): array
    {
        // slice lang url part
        $path = array_slice($path, 1);

        return array_map(function ($part) {
            return ucfirst($part);
        }, $path);
    }

    /**
     * @param array $path
     */
    protected function matchFromPath(array $path): void
    {
        $action = $this->defaultAction;
        $this->controller = $this->makeController($path);

        if (!class_exists($this->controller)) {
            $this->controller = $this->makeController(array_slice($path, 0, -1));

            $action = array_slice($path, -1, 1);
            $action = $action[0] ?? $this->defaultAction;
        }

        $this->action = $this->normalizeActionName(strtolower($action)) . 'Action';
    }

    /**
     * @param array $path
     * @return string
     */
    protected function makeController(array $path): string
    {
        if (count($path) > 0) {
            return $this->controllerNamespace . $this->normalizeControllerPath(implode('\\', $path)) . 'Controller';
        }

        return  $this->controllerNamespace . $this->defaultController;
    }

    /**
     * @param string $target
     * @return string
     */
    protected function normalizeActionName(string $target): string
    {
        if (!Str::contains($target, '-')) {
            return $target;
        }

        return $this->normalize($target);
    }

    /**
     * @param string $target
     * @return string
     */
    protected function normalizeControllerPath(string $target): string
    {
        if (!Str::contains($target, '-')) {
            return $target;
        }

        $target = explode('\\', $target);
        $target = array_map(function ($part) {
            if (!Str::contains($part, '-')) {
                return $part;
            }

            return $this->normalize($part, false);
        }, $target);

        return implode('\\', $target);
    }

    /**
     * @param string $target
     * @param bool $asAction
     * @return string
     */
    protected function normalize(string $target, bool $asAction = true): string
    {
        $target = explode('-', $target);
        $target = array_map(function ($part, $index) use ($asAction) {
            if (!$asAction || $index > 0) {
                return ucfirst($part);
            }

            return $part;
        }, $target, array_keys($target));

        return implode('', $target);
    }
}