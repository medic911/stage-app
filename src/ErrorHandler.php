<?php

namespace StageApp;

use StageApp\Interfaces\ErrorHandlerInterface;
use Throwable;

/**
 * Class ErrorHandler
 * @package StageApp
 */
class ErrorHandler implements ErrorHandlerInterface
{
    /**
     * @param Throwable $e
     */
    public function handle(Throwable $e): void
    {
        echo $e->getMessage();
        exit();
    }
}