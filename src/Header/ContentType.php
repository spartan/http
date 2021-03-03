<?php

namespace Spartan\Http\Header;

use Spartan\Http\Definition\HeaderInterface;
use Spartan\Http\Definition\HeaderTrait;

/**
 * ContentType Header
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class ContentType implements HeaderInterface
{
    use HeaderTrait;

    const NAME = 'Content-Type';

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
                : [$directives]
        );
    }
}
