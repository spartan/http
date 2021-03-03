<?php

namespace Spartan\Http\Exception;

/**
 * HttpBadRequest Exception
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class HttpBadRequest extends Http
{
    const CODE = 400;
    const TEXT = 'Bad Request';
}
