<?php

namespace StageApp\Stages;

use StageApp\App;
use StageApp\Exceptions\InvalidResponseType;
use StageApp\Exceptions\RouteNotFoundException;
use StageApp\Http\Response;
use StageApp\Interfaces\StageInterface;
use StageApp\Router;

/**
 * Class StageMakeResponse
 * @package StageApp\Stages
 */
class StageMakeResponse implements StageInterface
{
    /**
     * @param App $app
     * @return Response|mixed
     * @throws InvalidResponseType
     */
    public function handle(App $app)
    {
        $router = new Router('');
        try {
            $callable = $router->match($app->getRequest());
        } catch (RouteNotFoundException $e) {
            return Response::e404($e->getMessage());
        }

        return $this->tryMakeResponse(call_user_func($callable));
    }

    /**
     * @param $content
     * @return Response
     * @throws InvalidResponseType
     */
    protected function tryMakeResponse($content): Response
    {
        if ($content instanceof Response) {
            return $content;
        }

        if (is_string($content) || is_integer($content)) {
            return new Response($content);
        }

        if (is_array($content)) {
            return Response::json($content);
        }

        throw new InvalidResponseType('Invalid response type');
    }
}