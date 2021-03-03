<?php

namespace Spartan\Http\Definition;

use Spartan\Http\Http;

/**
 * ResponseTrait
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
trait ResponseTrait
{
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
     * @return array
     */
    public static function getNoBodyHeaders()
    {
        return [Http::NO_CONTENT, Http::RESET_CONTENT, Http::NOT_MODIFIED];
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
