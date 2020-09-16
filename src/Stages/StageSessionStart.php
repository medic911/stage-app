<?php

namespace StageApp\Stages;

use StageApp\App;
use StageApp\Interfaces\StageInterface;

/**
 * Class StageSessionStart
 * @package StageApp\Stages
 */
class StageSessionStart implements StageInterface
{
    /**
     * @param App $context
     * @return mixed|void
     */
    public function handle($context)
    {
        session_start();
    }
}