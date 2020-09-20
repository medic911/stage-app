<?php

namespace StageApp;

use StageApp\Exceptions\NotAllowedResponseException;
use StageApp\Http\Request;
use StageApp\Interfaces\ErrorHandlerInterface;
use StageApp\Traits\Singleton;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Throwable;

class App
{
    use Singleton;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var Session
     */
    protected $session;

    /**
     * App constructor.
     */
    public function __construct()
    {
        $this->request = new Request;
        $this->session = new Session;
        $this->response = new Response;
    }

    /**
     * @param array $stages
     * @param ErrorHandlerInterface $errorHandler
     */
    public function run(array $stages, ErrorHandlerInterface $errorHandler): void
    {
        try {
            $stageLine = new StageLine;
            array_walk($stages, function ($stage) use ($stageLine) {
                $stageLine->stage($stage);
            });

            $stageLine->process($this, function ($result) {
                $this->handleStage($result);
            });

            $this->sendResponse();
        } catch (Throwable $e) {
            $errorHandler->handle($e);
        }
    }

    /**
     * @throws NotAllowedResponseException
     */
    protected function sendResponse(): void
    {
        if (!$this->response instanceof Response) {
            throw new NotAllowedResponseException;
        }

        $this->response->send();
    }

    /**
     * @param Response $response
     * @throws NotAllowedResponseException
     */
    public function terminateWith(Response $response): void
    {
        $this->response = $response;
        $this->sendResponse();
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @return Session
     */
    public function getSession(): Session
    {
        return $this->session;
    }

    /**
     * @param mixed $result
     */
    protected function handleStage($result): void
    {
        if ($result instanceof Request) {
            $this->request = $result;
        }

        if ($result instanceof Response) {
            $this->response = $result;
        }

        if ($result instanceof Session) {
            $this->session = $result;
        }
    }
}