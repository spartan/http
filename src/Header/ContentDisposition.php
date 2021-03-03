<?php

namespace Spartan\Http\Header;

use Spartan\Http\Definition\HeaderInterface;
use Spartan\Http\Definition\HeaderTrait;

/**
 * ContentDisposition Header
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class ContentDisposition implements HeaderInterface
{
    use HeaderTrait;

    const NAME = 'Content-Disposition';
}
