<?php

namespace Spartan\Http\Exception;

/**
 * HttpForbidden Exception
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class HttpForbidden extends Http
{
    const CODE = 403;
    const TEXT = 'Forbidden';
}
