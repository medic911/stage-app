<?php

namespace StageApp;

use StageApp\Interfaces\ErrorHandlerInterface;
use StageApp\Interfaces\StageInterface;
use StageApp\Http\Request;
use StageApp\Http\Response;
use StageApp\Traits\Singleton;

/**
 * Class App
 * @package StageApp
 */
class App
{
    use Singleton;

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
            $this->setOptions($options)
                 ->filterStages()
                 ->goThroughStages()
                 ->terminateWith($this->response);
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
     * @return $this
     */
    protected function goThroughStages(): self
    {
        foreach ($this->stages as $stage) {
            $this->handleStage($stage);
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function filterStages(): self
    {
        $this->stages = array_filter($this->stages, function ($stage) {
            return $stage instanceof StageInterface;
        });

        return $this;
    }

    /**
     * @param StageInterface $stage
     */
    protected function handleStage(StageInterface $stage): void
    {
        $result = $stage->handle($this);

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