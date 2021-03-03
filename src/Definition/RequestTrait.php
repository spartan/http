<?php

namespace Spartan\Http\Definition;

/**
 * RequestTrait
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
trait RequestTrait
{
    /**
     * Check if request is safe
     *
     * @return bool
     */
    public function isSafe(): bool
    {
        return in_array(
            $this->getMethod(),
            [self::HEAD, self::GET, self::OPTIONS, self::TRACE]
        );
    }

    /**
     * Check if request is secure
     *
     * @return bool
     */
    public function isSecure(): bool
    {
        return $this->getUri()->getScheme() === 'https';
    }

    /**
     * Check if request is XHR
     *
     * @return bool
     */
    public function isXhr(): bool
    {
        return strtolower($this->getHeaderLine('X-Requested-With')) === 'xmlhttprequest';
    }

    /**
     * Check if request is pre-flight for CORS
     *
     * @return bool
     */
    public function isPreFlight(): bool
    {
        return $this->getMethod() == 'OPTIONS'
            && $this->getServerParam('HTTP_ACCESS_CONTROL_REQUEST_METHOD', false)
            && $this->getServerParam('HTTP_ACCESS_CONTROL_REQUEST_HEADERS', false);
    }

    /*
     * Extra
     */

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasServerParam(string $name): bool
    {
        return array_key_exists($name, $this->getServerParams());
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasQueryParam(string $name): bool
    {
        return array_key_exists($name, $this->getQueryParams());
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasAttribute(string $name): bool
    {
        return array_key_exists($name, $this->getAttributes());
    }

    /**
     * @param string $name
     * @param mixed  $default
     *
     * @return mixed
     */
    public function getServerParam(string $name, $default = null)
    {
        return $this->getServerParams()[$name] ?? $default;
    }

    /**
     * @param string $name
     * @param mixed  $default
     *
     * @return mixed
     */
    public function getQueryParam(string $name, $default = null)
    {
        return $this->getQueryParams()[$name] ?? $default;
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return $this
     */
    public function withQueryParam(string $name, $value): self
    {
        return $this->withQueryParams([$name => $value] + $this->getQueryParams());
    }

    /**
     * @param string $name
     * @param mixed  $default
     *
     * @return mixed
     */
    public function getParam(string $name, $default = null)
    {
        if ($this->getParsedBody() && isset($this->getParsedBody()[$name])) {
            return $this->getParsedBody()[$name];
        } elseif ($this->hasQueryParam($name)) {
            return $this->getQueryParam($name);
        } elseif ($this->hasAttribute($name)) {
            return $this->getAttribute($name);
        }

        return $this->getServerParam($name, $default);
    }

    /*
     * Client
     */

    /**
     * @param string $trustedProxies
     * @param string $trustedHeader
     *
     * @return string
     */
    public function getClientIp(string $trustedProxies = '', $trustedHeader = 'HTTP_X_FORWARDED_FOR'): string
    {
        $trustedProxies = $trustedProxies ?: getenv('TRUSTED_PROXIES');

        if ($trustedProxies) {
            $ips = array_diff(
                array_map(
                    'trim',
                    explode(',', $this->getHeaderLine($trustedHeader))
                ),
                $trustedProxies
            );

            if (count($ips)) {
                return array_pop($ips);
            }

            return '';
        }

        $ips = explode(
            ',',
            (string)$this->getServerParam(
                $trustedHeader,
                $this->getServerParam(
                    'HTTP_X_REAL_IP',
                    $this->getServerParam('REMOTE_ADDR', '')
                )
            )
        );

        return trim(array_pop($ips));
    }

    /**
     * Get client UserAgent
     *
     * @return string
     */
    public function getClientAgent(): string
    {
        return (string)($this->getServerParam('HTTP_USER_AGENT') ?: $this->getHeaderLine('User-Agent'));
    }
}
