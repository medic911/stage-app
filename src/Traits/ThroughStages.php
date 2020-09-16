<?php

namespace StageApp\Traits;

use StageApp\Interfaces\StageInterface;

/**
 * Trait ThroughStages
 * @package StageApp\Traits
 */
trait ThroughStages
{
    /**
     *
     */
    public function goThroughStages(): void
    {
        foreach ($this->getStages() as $stage) {
            if (!$stage instanceof StageInterface) {
                continue;
            }

            $this->handleStageResult($stage->handle($this));
        }
    }

    /**
     * @return array
     */
    protected function getStages(): array
    {
        return [];
    }

    /**
     * @param StageInterface $stage
     */
    protected function handleStageResult($result): void
    {
        //
    }
}