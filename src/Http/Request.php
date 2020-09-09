<?php

namespace StageApp\Http;

use StageApp\Traits\Singleton;

class Request
{
    use Singleton;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $method;

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $name
     * @param null $default
     * @return mixed|null
     */
    public function fromGet(string $name, $default = null)
    {
        return $_GET[$name] ?: $default;
    }

    /**
     * @param string $name
     * @param null $default
     * @return mixed|null
     */
    public function fromPost(string $name, $default = null)
    {
        return $_POST[$name] ?: $default;
    }

    /**
     * @param string $name
     * @param null $default
     * @return mixed|null
     */
    public function fromRequest(string $name, $default = null)
    {
        return $this->fromGet($name) ?: $this->fromPost($name, $default);
    }

    /**
     * @return static
     */
    public function make(): self
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->path = (string) parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


        return $this;
    }
}