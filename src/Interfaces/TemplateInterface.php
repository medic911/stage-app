<?php

namespace StageApp\Interfaces;

interface TemplateInterface
{
    /**
     * @param string $target
     * @param array $context
     * @return string
     */
    public function render(string $target, array $context): string;
}