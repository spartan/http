<?php

namespace Spartan\Http\Exception;

/**
 * HttpNotImplemented Exception
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class HttpNotImplemented extends Http
{
    const CODE = 501;
    const TEXT = 'Not Implemented';
}
