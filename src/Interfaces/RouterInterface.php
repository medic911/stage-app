<?php

namespace StageApp\Interfaces;

use StageApp\Exceptions\RouteNotFoundException;
use StageApp\Http\Request;

/**
 * Interface RouterInterface
 * @package StageApp\Interfaces
 */
interface RouterInterface
{
    /**
     * @param Request $request
     * @throws RouteNotFoundException
     * @return array - Callable
     */
    public function match(Request $request): array;
}