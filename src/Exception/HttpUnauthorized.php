<?php

namespace Spartan\Http\Exception;

/**
 * HttpUnauthorized Exception
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class HttpUnauthorized extends Http
{
    const CODE = 401;
    const TEXT = 'Unauthorized';
}
