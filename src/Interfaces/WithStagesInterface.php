<?php

namespace StageApp\Interfaces;

/**
 * Interface WithStagesInterface
 * @package StageApp\Interfaces
 */
interface WithStagesInterface
{
    /**
     * @return $this
     */
    public function goThroughStages(): void;
}