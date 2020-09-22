<?php

namespace StageApp\Stages;

use Illuminate\Support\Arr;
use StageApp\App;
use StageApp\Http\Request;

class MakeRequest
{
    /**
     * @param App $app
     * @return Request
     */
    public function __invoke(App $app): Request
    {
        $request = Request::createFromGlobals();
        $request->setSession($app->getSession());
        $request->setLocale(Arr::get($request->getPathInfoAsArray(), 0, 'en'));

        return $request;
    }
}