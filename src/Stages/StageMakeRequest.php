<?php

namespace StageApp\Stages;

use StageApp\App;
use StageApp\Http\Request;
use StageApp\Interfaces\StageInterface;

/**
 * Class StageMakeRequest
 * @package StageApp\Stages
 */
class StageMakeRequest implements StageInterface
{
    /**
     * @param App $app
     * @return mixed|void
     */
    public function handle(App $app)
    {
        return Request::getInstance()->make();
    }
}