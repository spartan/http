<?php

namespace Spartan\Http\Definition;

use Spartan\Http\Header\Cookie;

/**
 * MessageTrait
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
trait MessageTrait
{
    /*
     * Headers
     */

    /**
     * Check if request is JSON
     *
     * @return bool
     */
    public function isJson(): bool
    {
        return strpos($this->getHeaderLine('Content-Type'), 'application/json') !== false
            || strpos($this->getHeaderLine('Accept'), 'application/json') !== false;
    }

    /**
     * Check if request is XML
     *
     * @return bool
     */
    public function isXml(): bool
    {
        return strpos($this->getHeaderLine('Content-Type'), 'application/xml') !== false;
    }

    /**
     * Check if request is plain text
     *
     * @return bool
     */
    public function isText(): bool
    {
        return strpos($this->getHeaderLine('Content-Type'), 'text/plain') !== false;
    }

    /**
     * Check if request is plain text
     *
     * @return bool
     */
    public function isHtml(): bool
    {
        return strpos($this->getHeaderLine('Content-Type'), 'text/html') !== false;
    }

    /**
     * @param mixed[] $headers
     *
     * @return self
     * @throws \InvalidArgumentException
     */
    public function withHeaders(array $headers): self
    {
        $message = clone $this;

        foreach ($headers as $name => $header) {
            if ($header instanceof \Laminas\Mail\Header\HeaderInterface) {
                $message = $message->withHeader($header->getFieldName(), $header->getFieldValue());
            } elseif ($header instanceof HeaderInterface) {
                $message = $message->withHeader($header::NAME, $header->value());
            } else {
                $message = $message->withHeader($name, $header);
            }
        }

        return $message;
    }

    /**
     * @return self
     * @throws \InvalidArgumentException
     */
    public function asJson(): self
    {
        return $this->withHeader('Content-Type', 'application/json');
    }

    /**
     * @return self
     * @throws \InvalidArgumentException
     */
    public function asText(): self
    {
        return $this->withHeader('Content-Type', 'text/plain');
    }

    /**
     * @return self
     * @throws \InvalidArgumentException
     */
    public function asHtml(): self
    {
        return $this->withHeader('Content-Type', 'text/html');
    }

    /**
     * @return self
     * @throws \InvalidArgumentException
     */
    public function asXml(): self
    {
        return $this->withHeader('Content-Type', 'application/xml');
    }

    /**
     * @param Cookie|string $cookie
     *
     * @return self
     * @throws \InvalidArgumentException
     */
    public function withCookie($cookie): self
    {
        return $this->withAddedHeader('Set-Cookie', (string)$cookie);
    }

    /**
     * @param array $cookies
     *
     * @return self
     * @throws \InvalidArgumentException
     */
    public function withCookies(array $cookies): self
    {
        $message = clone $this;

        foreach ($cookies as $cookie) {
            $message = $message->withAddedHeader('Set-Cookie', (string)$cookie);
        }

        return $message;
    }

    /*
     * Body
     */

    /**
     * @param string $body String body to write
     *
     * @return self
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function withStringBody(string $body): self
    {
        $stream = new \Laminas\Diactoros\Stream('php://memory', 'rw');
        $stream->write($body);

        return $this->withBody($stream);
    }

    /**
     * @param mixed $json JSON
     *
     * @return self
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function withJsonBody($json): self
    {
        return $this->asJson()
                    ->withStringBody(json_encode($json));
    }

    /**
     * @return array
     * @throws \RuntimeException
     */
    public function getJsonBody(): array
    {
        return (array)json_decode(trim((string)$this->getBody()), true);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $string = '';
        foreach ($this->getHeaders() as $header => $value) {
            $string .= "{$header}: " . $this->getHeaderLine($header) . PHP_EOL;
        }

        return $string . PHP_EOL . (string)$this->getBody();
    }
}
