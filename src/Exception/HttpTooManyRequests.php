<?php

namespace Spartan\Http\Exception;

/**
 * HttpTooManyRequests Exception
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class HttpTooManyRequests extends Http
{
    const CODE = 429;
    const TEXT = 'Too Many Requests';
}
