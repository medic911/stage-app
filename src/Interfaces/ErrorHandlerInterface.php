<?php

namespace StageApp\Interfaces;

use Throwable;

interface ErrorHandlerInterface
{
    /**
     * @param Throwable $e
     */
    public function handle(Throwable $e): void;
}