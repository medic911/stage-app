<?php

namespace StageApp\Interfaces;

use StageApp\App;

/**
 * Interface AppStageInterface
 */
interface StageInterface
{
    /**
     * @param mixed $context
     * @return mixed
     */
    public function handle($context);
}