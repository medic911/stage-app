<?php

namespace StageApp;

use StageApp\Http\Request;
use StageApp\Interfaces\ErrorHandlerInterface;
use StageApp\Interfaces\WithStagesInterface;
use StageApp\Traits\Singleton;
use StageApp\Traits\ThroughStages;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class App
 * @package StageApp
 */
class App implements WithStagesInterface
{
    use Singleton, ThroughStages;

    /**
     * @var array
     */
    protected $stages;

    /**
     * @var ErrorHandlerInterface
     */
    protected $errorHandler;

    /**
     * @var Request|null
     */
    protected $request;

    /**
     * @var Response|null
     */
    protected $response;

    /**
     * App constructor.
     */
    private function __construct()
    {
        $this->request = null;
        $this->response = null;
        $this->errorHandler = new ErrorHandler;
    }

    /**
     * @param array $options
     */
    public function run(array $options): void
    {
        try {
            $this->setOptions($options);
            $this->goThroughStages();
            $this->terminateWith($this->response);
        } catch (\Throwable $e) {
            $this->errorHandler->handle($e);
        }
    }

    /**
     * @param mixed $response
     */
    public function terminateWith($response): void
    {
        if ($response instanceof Response) {
            $response->send();
        }

        exit();
    }

    /**
     * @return Request|null
     */
    public function getRequest(): ?Request
    {
        return $this->request;
    }

    /**
     * @return Response|null
     */
    public function getResponse(): ?Response
    {
        return $this->response;
    }

    /**
     * @return array
     */
    protected function getStages(): array
    {
        return $this->stages;
    }

    /**
     * @param mixed $result
     */
    protected function handleStageResult($result): void
    {
        if ($result instanceof Request) {
            $this->request = $result;
        }

        if ($result instanceof Response) {
            $this->response = $result;
        }
    }

    /**
     * @param array $options
     * @return $this
     */
    protected function setOptions(array $options): self
    {
        $this->stages = $options['stages'] ?? [];

        if (array_key_exists('error_handler', $options) && $options['error_handler'] instanceof ErrorHandlerInterface) {
            $this->errorHandler = $options['error_handler'];
        }

        return $this;
    }
}