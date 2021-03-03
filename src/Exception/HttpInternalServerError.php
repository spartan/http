<?php

namespace Spartan\Http\Exception;

/**
 * HttpInternalServerError Exception
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class HttpInternalServerError extends Http
{
    const CODE = 500;
    const TEXT = 'Internal Server Error';
}
