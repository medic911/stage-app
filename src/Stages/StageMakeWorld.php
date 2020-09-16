<?php

namespace StageApp\Stages;

use StageApp\Interfaces\StageInterface;

/**
 * Class StageMakeWorld
 * @package StageApp\Stages
 */
class StageMakeWorld implements StageInterface
{
    public function handle($context)
    {
        return ' World!!!';
    }
}