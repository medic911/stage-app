<?php

namespace StageApp\Stages;

use StageApp\App;
use StageApp\Exceptions\InvalidResponseType;
use StageApp\Exceptions\RouteNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use StageApp\Classes\ResponseFactory;
use StageApp\Interfaces\StageInterface;
use StageApp\Router;

/**
 * Class StageMakeResponse
 * @package StageApp\Stages
 */
class StageMakeResponse implements StageInterface
{
    /**
     * @param App $context
     * @return Response|mixed
     * @throws InvalidResponseType
     */
    public function handle($context)
    {
        $router = new Router('');
        try {
            $callable = $router->match($context->getRequest());
        } catch (RouteNotFoundException $e) {
            return ResponseFactory::e404($e->getMessage());
        }

        return ResponseFactory::fromContent(call_user_func($callable));
    }
}