<?php

namespace Spartan\Http\Exception;

/**
 * HttpNotFound Exception
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class HttpNotFound extends Http
{
    const CODE = 404;
    const TEXT = 'Not Found';
}
