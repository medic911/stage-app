<?php

namespace StageApp\Stages;

use StageApp\App;
use Symfony\Component\HttpFoundation\Session\Session;

class MakeSession
{
    /**
     * @param App $app
     * @return Session
     */
    public function __invoke(App $app): Session
    {
        $session = new Session;
        $session->start();

        return $session;
    }
}