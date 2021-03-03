<?php

namespace Spartan\Http\Exception;

/**
 * HttpMethodNotAllowed Exception
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class HttpMethodNotAllowed extends Http
{
    const CODE = 405;
    const TEXT = 'Method Not Allowed';
}
