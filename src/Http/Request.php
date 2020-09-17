<?php

namespace StageApp\Http;

class Request extends \Symfony\Component\HttpFoundation\Request
{
    /**
     * @var array
     */
    protected $pathAsArray;

    /**
     * @var string|null
     */
    protected $lang;

    /**
     * Request constructor.
     * @param array $query
     * @param array $request
     * @param array $attributes
     * @param array $cookies
     * @param array $files
     * @param array $server
     * @param null $content
     */
    public function __construct(
        array $query = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        $content = null
    ) {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->makePathAsArray();
        $this->lang = $this->basePathAsArray[0] ?? 'en';
    }

    /**
     * @return array
     */
    public function getPathAsArray(): array
    {
        return $this->basePathAsArray;
    }

    /**
     * @return string|null
     */
    public function getLang(): ?string
    {
        return $this->lang;
    }

    /**
     * @return $this
     */
    protected function makePathAsArray(): self
    {
        $path = explode('/', $this->getPathInfo());
        $this->basePathAsArray = array_filter($path, function ($part) {
            return !empty($part) &&
                $part !== '.' &&
                $part !== '..' &&
                trim($part) !== '';
        });

        $this->basePathAsArray = array_values($this->basePathAsArray);

        return $this;
    }
}