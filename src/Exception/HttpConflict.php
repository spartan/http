<?php

namespace Spartan\Http\Exception;

/**
 * HttpConflict Exception
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class HttpConflict extends Http
{
    const CODE = 409;
    const TEXT = 'Conflict';
}
