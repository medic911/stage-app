<?php

namespace StageApp\Stages;

use StageApp\Interfaces\StageInterface;

/**
 * Class StageMakeHello
 * @package StageApp\Stages
 */
class StageMakeHello implements StageInterface
{
    /**
     * @param mixed $context
     * @return mixed|void
     */
    public function handle($context)
    {
        return 'Hello';
    }
}