<?php

namespace Spartan\Http;

use Spartan\Http\Definition\MessageTrait;
use Spartan\Http\Definition\RequestTrait;

/**
 * Extended ServerRequest
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class ServerRequest extends \Laminas\Diactoros\ServerRequest
{
    const HEAD    = 'HEAD';
    const GET     = 'GET';
    const POST    = 'POST';
    const PUT     = 'PUT';
    const PATCH   = 'PATCH';
    const DELETE  = 'DELETE';
    const PURGE   = 'PURGE';
    const OPTIONS = 'OPTIONS';
    const TRACE   = 'TRACE';
    const CONNECT = 'CONNECT';

    use MessageTrait;
    use RequestTrait;

    /**
     * @param string  $name
     * @param mixed[] $args
     *
     * @return $this|bool
     */
    public function __call(string $name, array $args)
    {
        if (in_array(
            $name,
            [
                self::HEAD,
                self::GET,
                self::POST,
                self::PUT,
                self::PATCH,
                self::OPTIONS,
                self::PURGE,
                self::TRACE,
                self::CONNECT,
            ]
        )) {
            return $this->getMethod() === strtoupper($name);
        }

        return $this;
    }
}
