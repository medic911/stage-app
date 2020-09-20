<?php

namespace StageApp\Stages;

use StageApp\App;
use StageApp\Exceptions\NotAllowedResponseException;
use StageApp\Exceptions\RouteNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use StageApp\Facades\ResponseFactory;
use StageApp\Router;

class MakeResponse
{
    /**
     * @param App $app
     * @return Response|mixed
     * @throws NotAllowedResponseException
     */
    public function __invoke(App $app): Response
    {
        $router = new Router('');
        try {
            $callable = $router->match($app->getRequest());
        } catch (RouteNotFoundException $e) {
            return ResponseFactory::e404($e->getMessage());
        }

        return ResponseFactory::fromContent(call_user_func($callable));
    }
}