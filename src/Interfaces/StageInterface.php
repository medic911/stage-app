<?php

namespace StageApp\Interfaces;

use StageApp\App;

/**
 * Interface AppStageInterface
 */
interface StageInterface
{
    /**
     * @param App $app
     * @return mixed
     */
    public function handle(App $app);
}