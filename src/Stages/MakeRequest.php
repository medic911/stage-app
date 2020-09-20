<?php

namespace StageApp\Stages;

use StageApp\App;
use StageApp\Http\Request;

class MakeRequest
{
    /**
     * @param App $app
     * @return mixed|void
     */
    public function __invoke(App $app): Request
    {
        $request = Request::createFromGlobals();
        $request->setSession($app->getSession());

        return $request;
    }
}