<?php

namespace Spartan\Http\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Spartan\Http\Http;

/**
 * Cors Middleware
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class Cors implements MiddlewareInterface
{
    /**
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $headers = self::headers($request);

        /*
         * If is pre-flight
         */
        if (isset($headers['Access-Control-Allow-Methods'])) {
            foreach ($headers as $name => $value) {
                header("{$name}: {$value}");
            }

            exit(0);
        }

        return Http::response($handler->handle($request))->withHeaders($headers);
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return mixed[]
     */
    public static function headers(ServerRequestInterface $request): array
    {
        $headers = [];

        $origin = $request->getServerParams()['HTTP_ORIGIN'] ?? '*';

        if (in_array($origin, explode(',', getenv('CORS_ALLOW_ORIGINS') ?: ''))) {
            $headers = [
                'Access-Control-Allow-Origin'      => $origin,
                'Access-Control-Allow-Credentials' => 'true',
                'Access-Control-Max-Age'           => 86400,
                'Access-Control-Expose-Headers'    => getenv('CORS_EXPOSE_HEADERS'),
            ];
        }

        if (Http::request($request)->isPreFlight()) {
            $headers += [
                'Access-Control-Allow-Methods' => getenv('CORS_ALLOW_METHODS'),
                'Access-Control-Allow-Headers' => getenv('CORS_ALLOW_HEADERS'),
            ];
        }

        return $headers;
    }
}
