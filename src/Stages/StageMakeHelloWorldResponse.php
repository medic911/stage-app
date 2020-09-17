<?php

namespace StageApp\Stages;

use StageApp\App;
use StageApp\Interfaces\StageInterface;
use StageApp\Interfaces\WithStagesInterface;
use StageApp\Traits\ThroughStages;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StageMakeHelloWorldResponse
 * @package StageApp\Stages
 */
class StageMakeHelloWorldResponse implements StageInterface, WithStagesInterface
{
    use ThroughStages;

    /**
     * @var string
     */
    protected $helloWorld;

    /**
     * @param App $context
     * @return mixed|void
     */
    public function handle($context)
    {
        $this->goThroughStages();

        return new Response($this->helloWorld);
    }

    /**
     * @return array
     */
    protected function getStages(): array
    {
        return [
            new StageMakeHello,
            new StageMakeWorld,
        ];
    }

    /**
     * @param $result
     */
    protected function handleStageResult($result): void
    {
        $this->helloWorld .= $result;
    }
}