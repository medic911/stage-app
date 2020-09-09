<?php

namespace StageApp\Interfaces;

/**
 * Interface AppErrorHandlerInterface
 * @package StageApp\Interfaces
 */
interface ErrorHandlerInterface
{
    /**
     * @param \Throwable $e
     */
    public function handle(\Throwable $e): void;
}