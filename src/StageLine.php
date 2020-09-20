<?php

namespace StageApp;

class StageLine
{
    /**
     * @var array
     */
    protected $stages;

    /**
     * @param callable $stage
     * @return $this
     */
    public function stage(callable $stage): self
    {
        $this->stages[] = $stage;

        return $this;
    }

    /**
     * @param $context
     * @param callable $handler
     * @return $this
     */
    public function process($context, callable $handler): self
    {
        foreach ($this->stages as $stage) {
            call_user_func($handler, call_user_func($stage, $context));
        }

        return $this;
    }
}