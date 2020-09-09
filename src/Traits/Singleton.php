<?php

namespace StageApp\Traits;

trait Singleton
{
    /**
     * @var self|null
     */
    protected static $instance = null;

    /**
     * Singleton constructor.
     */
    private function __construct()
    {
        //
    }

    /**
     *
     */
    private function __clone()
    {
        //
    }

    /**
     * @return static
     */
    public static function getInstance(): self
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}