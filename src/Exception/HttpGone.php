<?php

namespace Spartan\Http\Exception;

/**
 * HttpGone Exception
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class HttpGone extends Http
{
    const CODE = 410;
    const TEXT = 'Gone';
}
