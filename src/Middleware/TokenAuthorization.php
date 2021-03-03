<?php

namespace Spartan\Http\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Spartan\Http\Exception\HttpBadRequest;
use Spartan\Http\Exception\HttpUnauthorized;

/**
 * TokenAuthorization Middleware
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class TokenAuthorization implements MiddlewareInterface
{
    protected string $header;

    public function __construct(string $header = 'X-Token')
    {
        $this->header = $header;
    }

    /**
     * {@inheritdoc}
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     * @throws HttpBadRequest
     * @throws HttpUnauthorized
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $token = $request->getHeaderLine($this->header);

        if (!$token) {
            throw new HttpBadRequest('Missing auth token!', $request);
        }

        if ($token != getenv('API_TOKEN')) {
            throw new HttpUnauthorized('Invalid token!', $request);
        }

        return $handler->handle($request);
    }
}
