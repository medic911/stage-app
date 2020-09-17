<?php

namespace StageApp\Stages;

use StageApp\App;
use StageApp\Http\Request;
use StageApp\Interfaces\StageInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class StageMakeRequest
 * @package StageApp\Stages
 */
class StageMakeRequest implements StageInterface
{
    /**
     * @param App $context
     * @return mixed|void
     */
    public function handle($context)
    {
        return Request::createFromGlobals();
    }
}