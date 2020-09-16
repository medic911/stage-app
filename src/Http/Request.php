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
     * @var array
     */
    protected $splittedPath;

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
     * @return array
     */
    public function getSplittedPath(): array
    {
        return $this->splittedPath;
    }

    /**
     * @return string
     */
    public function getLang(): string
    {
        return $this->splittedPath[0] ?? '';
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
     * @return bool
     */
    public function isPost(): bool
    {
        return $this->method === 'POST';
    }

    /**
     * @return bool
     */
    public function isGet(): bool
    {
        return $this->method === 'GET';
    }

    /**
     * @return static
     */
    public function make(): self
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->path = (string) parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $this->makeSplittedPath();

        return $this;
    }

    /**
     * @return $this
     */
    protected function makeSplittedPath(): self
    {
        $path = explode('/', $this->path);
        $this->splittedPath = array_filter($path, function ($part) {
            return !empty($part) &&
                $part !== '.' &&
                $part !== '..' &&
                trim($part) !== '';
        });

        $this->splittedPath = array_values($this->splittedPath);

        return $this;
    }
}