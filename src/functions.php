<?php

use Spartan\Http\Http;
use Spartan\Http\Response;
use Spartan\Http\ServerRequest;
use Spartan\Http\Uri;

if (!function_exists('http')) {
    /**
     * @param mixed $httpObject
     *
     * @return ServerRequest|Response|Uri
     */
    function http($httpObject)
    {
        if ($httpObject instanceof \Psr\Http\Message\ServerRequestInterface) {
            return Http::request($httpObject);
        }

        if ($httpObject instanceof \Psr\Http\Message\ResponseInterface) {
            return Http::response($httpObject);
        }

        if ($httpObject instanceof \Psr\Http\Message\UriInterface) {
            return Http::uri($httpObject);
        }

        throw new \InvalidArgumentException('Unsupported http object: ' . get_class($httpObject));
    }
}
