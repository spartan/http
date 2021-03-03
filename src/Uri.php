<?php

namespace Spartan\Http;

use Psr\Http\Message\UriInterface;

/**
 * Extended Uri Http
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class Uri extends \Laminas\Diactoros\Uri
{
    /**
     * Get user
     *
     * @return string
     */
    public function getUser(): string
    {
        return (string)(explode(':', $this->getUserInfo())[0]);
    }

    /**
     * Get pass
     *
     * @return string
     */
    public function getPass()
    {
        return (string)(explode(':', $this->getUserInfo())[1] ?? null);
    }

    /**
     * Get segment index in path
     *
     * @param int $index Segment index starting with 0
     *
     * @return string
     */
    public function getSegment($index = 0): string
    {
        return (string)(explode('/', trim($this->getPath(), '/'))[$index] ?? '');
    }

    /**
     * Get last segment in path
     *
     * @return string
     */
    public function getFirstSegment(): string
    {
        return (string)(explode('/', trim($this->getPath(), '/'))[0] ?? '');
    }

    /**
     * Get last segment in path
     *
     * @return string
     */
    public function getLastSegment(): string
    {
        $segments = explode('/', trim($this->getPath(), '/')) + [''];

        return array_pop($segments) ?: '';
    }

    /**
     * Get query params
     *
     * @return mixed[]
     */
    public function getQueryParams(): array
    {
        parse_str($this->getQuery(), $params);

        return $params;
    }

    /**
     * Get query param
     *
     * @param string $name Param name
     *
     * @return mixed
     */
    public function getQueryParam(string $name)
    {
        return $this->getQueryParams()[$name] ?? null;
    }

    /**
     * Check if it has query param
     *
     * @param string $name Param name
     *
     * @return bool
     */
    public function hasQueryParam(string $name): bool
    {
        return array_key_exists($name, $this->getQueryParams());
    }

    /**
     * With query params
     *
     * @param mixed[] $params Query params
     *
     * @return UriInterface
     */
    public function withQueryParams(array $params): UriInterface
    {
        return $this->withQuery(http_build_query($params));
    }

    /**
     * With query param
     *
     * @param string $param Key name
     * @param mixed  $value Key value
     *
     * @return UriInterface
     * @throws \InvalidArgumentException
     */
    public function withQueryParam(string $param, $value): UriInterface
    {
        $params         = $this->getQueryParams();
        $params[$param] = $value;

        $this->withQueryParams($params);

        return $this;
    }
}
