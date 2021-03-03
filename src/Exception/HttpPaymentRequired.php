<?php

namespace Spartan\Http\Exception;

/**
 * HttpPaymentRequired Exception
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class HttpPaymentRequired extends Http
{
    const CODE = 402;
    const TEXT = 'Payment Required';
}
