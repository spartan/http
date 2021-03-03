<?php

namespace Spartan\Http\Header;

use Spartan\Http\Definition\HeaderInterface;
use Spartan\Http\Definition\HeaderTrait;

/**
 * ContentLength Header
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class ContentLength implements HeaderInterface
{
    use HeaderTrait;

    const NAME = 'Content-Length';

    /**
     * ContentType constructor.
     *
     * @param mixed[]|mixed $directives
     */
    public function __construct($directives)
    {
        $this->withDirectives(
            is_array($directives)
                ? $directives
                : [(int)$directives]
        );
    }
}
