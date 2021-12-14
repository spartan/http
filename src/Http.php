<?php

namespace Spartan\Http;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Spartan\Http\Exception\HttpBadRequest;
use Spartan\Http\Exception\HttpConflict;
use Spartan\Http\Exception\HttpForbidden;
use Spartan\Http\Exception\HttpGone;
use Spartan\Http\Exception\HttpInternalServerError;
use Spartan\Http\Exception\HttpMethodNotAllowed;
use Spartan\Http\Exception\HttpNotAcceptable;
use Spartan\Http\Exception\HttpNotFound;
use Spartan\Http\Exception\HttpNotImplemented;
use Spartan\Http\Exception\HttpPaymentRequired;
use Spartan\Http\Exception\HttpPreconditionFailed;
use Spartan\Http\Exception\HttpServiceUnavailable;
use Spartan\Http\Exception\HttpTooManyRequests;
use Spartan\Http\Exception\HttpUnauthorized;

/**
 * Http Http
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class Http
{
    const EXCEPTION_MAP = [
        400 => HttpBadRequest::class,
        401 => HttpUnauthorized::class,
        402 => HttpPaymentRequired::class,
        403 => HttpForbidden::class,
        404 => HttpNotFound::class,
        405 => HttpMethodNotAllowed::class,
        406 => HttpNotAcceptable::class,
        409 => HttpConflict::class,
        410 => HttpGone::class,
        412 => HttpPreconditionFailed::class,
        429 => HttpTooManyRequests::class,
        500 => HttpInternalServerError::class,
        501 => HttpNotImplemented::class,
        503 => HttpServiceUnavailable::class,
    ];

    /**
     * @param ServerRequestInterface $request
     * @param ClientInterface|null   $client
     *
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws \ReflectionException
     * @throws \Spartan\Service\Exception\ContainerException
     * @throws \Spartan\Service\Exception\NotFoundException
     */
    public static function send(string $method, $uri, array $headers = [], $body = null): ResponseInterface
    {
        $client  = container()->get(ClientInterface::class);
        $request = container()->get(ServerRequestFactoryInterface::class)->createServerRequest($method, $uri);
        $request = self::request($request)->withHeaders($headers)->withParsedBody($body);

        return $client->sendRequest($request);
    }

    /**
     * @param mixed   $url
     * @param int     $statusCode
     * @param mixed[] $headers
     */
    public static function redirect($url, $statusCode = 302, array $headers = []): void
    {
        self::response()
            ->withHeaders(['location' => (string)$url] + $headers)
            ->withStatus($statusCode)
            ->send();
    }

    /**
     * Extend ServerRequest Psr
     *
     * @param ServerRequestInterface|null $request
     *
     * @return ServerRequest
     */
    public static function request(ServerRequestInterface $request = null)
    {
        if (!$request) {
            return new ServerRequest();
        }

        return new ServerRequest(
            $request->getServerParams(),
            $request->getUploadedFiles(),
            $request->getUri(),
            $request->getMethod(),
            $request->getBody(),
            $request->getHeaders(),
            $request->getCookieParams(),
            $request->getQueryParams(),
            $request->getParsedBody(),
            $request->getProtocolVersion()
        );
    }

    /**
     * Extend Response Psr
     *
     * @param ResponseInterface|null $response
     *
     * @return Response
     */
    public static function response(ResponseInterface $response = null)
    {
        if (!$response) {
            return new Response();
        }

        return new Response(
            $response->getBody(),
            $response->getStatusCode(),
            $response->getHeaders()
        );
    }

    /**
     * Extend Uri Psr
     *
     * @param UriInterface|null $uri
     *
     * @return Uri
     */
    public static function uri(UriInterface $uri = null)
    {
        if (!$uri) {
            return new Uri();
        }

        return new Uri((string)$uri);
    }

    /**
     * @param int|string $exceptionClass
     * @param mixed      $condition
     * @param mixed      $message
     */
    public static function throw($exceptionClass, $condition = false, $message = null): void
    {
        if ($condition instanceof \Closure) {
            $condition = $condition();
        }

        if (is_int($exceptionClass)) {
            $exceptionClass = self::EXCEPTION_MAP[$exceptionClass];
        }

        if (!$condition) {
            throw new $exceptionClass(is_string($message) ? $message : json_encode($message));
        }
    }
}
