<?php

namespace Spartan\Http\Header;

use Spartan\Http\Definition\HeaderInterface;
use Spartan\Http\Definition\HeaderTrait;

/**
 * MessageId Header
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class MessageId implements HeaderInterface
{
    use HeaderTrait;

    const NAME = 'Message-ID';

    /**
     * @return mixed|string
     * @throws \Exception
     */
    public function value()
    {
        return $this->directives[0] ?? self::generateId();
    }

    /**
     * @return string
     * @throws \Exception
     */
    public static function generateId()
    {
        $server = $_SERVER["SERVER_NAME"] ?? php_uname('n');

        $data = random_bytes(16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));

        return "{$uuid}@{$server}";
    }
}
