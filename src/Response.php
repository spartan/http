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
class Response extends \Laminas\Diactoros\Response
{
    use MessageTrait;

    const CONTINUE                             = 100; // informational
    const SWITCHING_PROTOCOLS                  = 101;
    const PROCESSING                           = 102;
    const OK                                   = 200; // success
    const CREATED                              = 201;
    const ACCEPTED                             = 202;
    const NON_AUTHORITATIVE_INFORMATION        = 203;
    const NO_CONTENT                           = 204;
    const RESET_CONTENT                        = 205;
    const PARTIAL_CONTENT                      = 206;
    const MULTI_STATUS                         = 207;
    const ALREADY_REPORTED                     = 208;
    const IM_USED                              = 226;
    const MULTIPLE_CHOICES                     = 300; // redirection
    const MOVED_PERMANENTLY                    = 301;
    const FOUND                                = 302;
    const SEE_OTHER                            = 303;
    const NOT_MODIFIED                         = 304;
    const USE_PROXY                            = 305;
    const RESERVED                             = 306;
    const TEMPORARY_REDIRECT                   = 307;
    const PERMANENTLY_REDIRECT                 = 308;
    const BAD_REQUEST                          = 400; // client error
    const UNAUTHORIZED                         = 401;
    const PAYMENT_REQUIRED                     = 402;
    const FORBIDDEN                            = 403;
    const NOT_FOUND                            = 404;
    const METHOD_NOT_ALLOWED                   = 405;
    const NOT_ACCEPTABLE                       = 406;
    const PROXY_AUTHENTICATION_REQUIRED        = 407;
    const REQUEST_TIMEOUT                      = 408;
    const CONFLICT                             = 409;
    const GONE                                 = 410;
    const LENGTH_REQUIRED                      = 411;
    const PRECONDITION_FAILED                  = 412;
    const REQUEST_ENTITY_TOO_LARGE             = 413;
    const REQUEST_URI_TOO_LONG                 = 414;
    const UNSUPPORTED_MEDIA_TYPE               = 415;
    const REQUESTED_RANGE_NOT_SATISFIABLE      = 416;
    const EXPECTATION_FAILED                   = 417;
    const I_AM_A_TEAPOT                        = 418;
    const MISDIRECTED_REQUEST                  = 421;
    const UNPROCESSABLE_ENTITY                 = 422;
    const LOCKED                               = 423;
    const FAILED_DEPENDENCY                    = 424;
    const UPGRADE_REQUIRED                     = 426;
    const PRECONDITION_REQUIRED                = 428;
    const TOO_MANY_REQUESTS                    = 429;
    const REQUEST_HEADER_FIELDS_TOO_LARGE      = 431;
    const UNAVAILABLE_FOR_LEGAL_REASONS        = 451;
    const INTERNAL_SERVER_ERROR                = 500; // server error
    const NOT_IMPLEMENTED                      = 501;
    const BAD_GATEWAY                          = 502;
    const SERVICE_UNAVAILABLE                  = 503;
    const GATEWAY_TIMEOUT                      = 504;
    const VERSION_NOT_SUPPORTED                = 505;
    const VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506;
    const INSUFFICIENT_STORAGE                 = 507;
    const LOOP_DETECTED                        = 508;
    const NOT_EXTENDED                         = 510;
    const NETWORK_AUTHENTICATION_REQUIRED      = 511;

    /**
     * Check if response is informational
     *
     * @return bool
     */
    public function isInformational(): bool
    {
        return $this->getStatusCode() < 200;
    }

    /**
     * Check if response is successful
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->getStatusCode() >= 200 && $this->getStatusCode() < 300;
    }

    /**
     * Check if response is informational
     *
     * @return bool
     */
    public function isRedirection()
    {
        return $this->getStatusCode() >= 300 && $this->getStatusCode() < 400;
    }

    /**
     * Check if response is error
     *
     * @return bool
     */
    public function isError()
    {
        return $this->getStatusCode() >= 400;
    }

    /**
     * @return mixed[]
     */
    public static function getNoBodyHeaders()
    {
        return [self::NO_CONTENT, self::RESET_CONTENT, self::NOT_MODIFIED];
    }

    /**
     * Send response body to client
     *
     * @return void
     * @throws \RuntimeException
     */
    public function send()
    {
        if (!headers_sent()) {
            foreach ($this->getHeaders() as $name => $values) {
                foreach ($values as $value) {
                    header(sprintf('%s: %s', $name, $value), false);
                }
            }

            // @see https://github.com/slimphp/Slim/issues/1730
            header(
                sprintf(
                    'HTTP/%s %s %s',
                    $this->getProtocolVersion(),
                    $this->getStatusCode(),
                    $this->getReasonPhrase()
                )
            );
        }

        if (!in_array($this->getStatusCode(), self::getNoBodyHeaders())) {
            $body = $this->getBody();
            if ($body->isSeekable()) {
                $body->rewind();
            }

            echo $body;
        }
    }
}
