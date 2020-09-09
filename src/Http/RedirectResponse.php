<?php

namespace StageApp\Http;

class RedirectResponse extends Response
{
    /**
     * RedirectResponse constructor.
     * @param string $redirectUrl
     * @param int $status
     */
    public function __construct(string $redirectUrl, int $status = 301)
    {
        parent::__construct("Redirecting to {$redirectUrl}...", $status);

        $this->withHeader('Location', $redirectUrl);
    }
}