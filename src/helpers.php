<?php

use StageApp\App;
use StageApp\Http\Request;
use Symfony\Component\HttpFoundation\Session\Session;

if (!function_exists('app')) {
    /**
     * @return App
     */
    function app(): App
    {
        return App::getInstance();
    }
}

if (!function_exists('request')) {
    /**
     * @return Request
     */
    function request(): Request
    {
        return app()->getRequest();
    }
}

if (!function_exists('session')) {
    /**
     * @return Session
     */
    function session(): Session
    {
        return app()->getSession();
    }
}