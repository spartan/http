<?php

namespace Spartan\Http\Definition;

/**
 * HeaderInterface
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
interface HeaderInterface
{
    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return mixed
     */
    public function value();
}
