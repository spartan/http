<?php

namespace Spartan\Http\Header;

use Spartan\Http\Definition\HeaderInterface;
use Spartan\Http\Definition\HeaderTrait;

/**
 * Cookie Http
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class Cookie implements HeaderInterface
{
    use HeaderTrait;

    const NAME           = 'Set-Cookie';
    const ROOT_PATH      = '/';
    const HTTP_ONLY      = true;
    const SECURE         = true;
    const SAME_SITE_LAX  = 'Lax';
    const SAME_SITE_NONE = 'None';

    /**
     * Cookie constructor.
     *
     * @param string $name
     * @param string $value
     * @param int    $ttl
     * @param string $path
     * @param string $domain
     * @param bool   $isSecure
     * @param bool   $isHttpOnly
     * @param string $sameSite
     *
     * @return Cookie
     */
    public static function create(
        string $name,
        string $value = '',
        string $domain = '',
        string $path = '/',
        int $ttl = 0,
        bool $isHttpOnly = false,
        bool $isSecure = false,
        string $sameSite = self::SAME_SITE_LAX
    ) {

        $directives = [
            $name      => $value,
            'Domain'   => $domain,
            'Path'     => $path ?: '/',
            'Max-Age'  => $ttl,
            'SameSite' => $sameSite,
        ];

        if ($isHttpOnly) {
            $directives[] = 'HttpOnly';
        }

        if ($isSecure) {
            $directives[] = 'Secure';
        }

        return new self($directives);
    }

    /**
     * @return self
     */
    public function withExpiresNever(): self
    {
        return $this->withDirectives(
            [
                'expiresAt' => time() + 100 * 365 * 24 * 3600 // +100 years
            ]
        );
    }
}
