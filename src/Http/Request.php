<?php

namespace StageApp\Http;

class Request extends \Symfony\Component\HttpFoundation\Request
{
    /**
     * @var array
     */
    protected $pathInfoAsArray;

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

        $this->makePathInfoAsArray();
    }

    /**
     * @return array
     */
    public function getPathInfoAsArray(): array
    {
        return $this->pathInfoAsArray;
    }

    /**
     * @return $this
     */
    protected function makePathInfoAsArray(): self
    {
        $path = explode('/', $this->getPathInfo());
        $this->pathInfoAsArray = array_filter($path, function ($part) {
            return !empty($part) &&
                $part !== '.' &&
                $part !== '..' &&
                trim($part) !== '';
        });

        $this->pathInfoAsArray = array_values($this->pathInfoAsArray);

        return $this;
    }
}