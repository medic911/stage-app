<?php

namespace StageApp\Interfaces;

/**
 * Interface StageInterface
 * @package StageApp\Interfaces
 */
interface StageInterface
{
    /**
     * @param mixed $context
     * @return mixed
     */
    public function handle($context);
}