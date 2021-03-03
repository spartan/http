<?php

namespace Spartan\Http\Exception;

/**
 * HttpPreconditionFailed Exception
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class HttpPreconditionFailed extends Http
{
    const CODE = 412;
    const TEXT = 'Precondition Failed';
}
