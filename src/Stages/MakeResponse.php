<?php

namespace StageApp\Stages;

use Illuminate\Support\Arr;
use StageApp\App;
use StageApp\Dummies\Foo;
use StageApp\Exceptions\NotAllowedResponseException;
use StageApp\Exceptions\RouteNotFoundException;
use StageApp\Router\AnnotatedRouter;
use Symfony\Component\HttpFoundation\Response;
use StageApp\Facades\ResponseFactory;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class MakeResponse
{
    /**
     * @param App $app
     * @return Response
     * @throws NotAllowedResponseException
     */
    public function __invoke(App $app): Response
    {
        $router = AnnotatedRouter::getInstance();

        try {
            $parameters = $router->matchRequest($app->getRequest());
            $response = call_user_func($parameters['callable'], ...$parameters['arguments']);
        } catch (ResourceNotFoundException|MethodNotAllowedException $e) {
            return ResponseFactory::e404($e->getMessage());
        }

        return ResponseFactory::fromContent($response);
    }
}