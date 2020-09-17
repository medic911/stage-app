<?php

namespace StageApp\Classes;

use StageApp\Exceptions\InvalidResponseType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ResponseFactory
 * @package StageApp\Http
 */
class ResponseFactory
{
    /**
     * @param $content
     * @return Response
     * @throws InvalidResponseType
     */
    public static function fromContent($content): Response
    {
        if ($content instanceof Response) {
            return $content;
        }

        if (is_string($content) || is_integer($content)) {
            return new Response($content);
        }

        if (is_array($content)) {
            return self::json($content);
        }

        throw new InvalidResponseType('Invalid response type');
    }

    /**
     * @param array $data
     * @param int $status
     * @return Response
     */
    public static function json(array $data, int $status = 200): Response
    {
        return new Response(json_encode($data), $status, [
            'content-type' => 'text/plain',
        ]);
    }

    /**
     * @param string $content
     * @return Response
     */
    public static function e404(string $content = '404 Not Found'): Response
    {
        return new Response($content, 404);
    }

    /**
     * @param string $content
     * @return Response
     */
    public static function e500(string $content = 'Something went wrong'): Response
    {
        return new Response($content, 500);
    }

    /**
     * @param string $url
     * @param int $status
     * @return RedirectResponse
     */
    public static function redirectTo(string $url, int $status = 302): RedirectResponse
    {
        return new RedirectResponse($url, $status);
    }
}