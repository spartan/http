<?php

namespace Spartan\Http\Exception;

/**
 * HttpNotAcceptable Exception
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class HttpNotAcceptable extends Http
{
    const CODE = 406;
    const TEXT = 'Not Acceptable';
}
