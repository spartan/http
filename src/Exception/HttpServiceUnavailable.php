<?php

namespace Spartan\Http\Exception;

/**
 * HttpServiceUnavailable Exception
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class HttpServiceUnavailable extends Http
{
    const CODE = 503;
    const TEXT = 'Service Unavailable';
}
