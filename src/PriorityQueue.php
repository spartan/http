<?php

namespace Spartan\Http;

/**
 * PriorityQueue Http
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class PriorityQueue extends \SplPriorityQueue
{
    const FIRST  = PHP_INT_MAX;
    const HIGHER = 100;
    const HIGH   = 50;
    const NORMAL = 0;
    const LOW    = -50;
    const LOWER  = -100;
    const LAST   = PHP_INT_MIN;

    protected int $serial = PHP_INT_MAX;

    /**
     * Fix: "Note: Multiple elements with the same priority will get de-queued in no particular order."
     *
     * @param mixed $value    Middleware name
     * @param mixed $priority Middleware priority
     *
     * @return true
     */
    public function insert($value, $priority = self::NORMAL)
    {
        if (!is_int($priority)) {
            $value    = $priority;
            $priority = self::NORMAL;
        }

        return parent::insert($value, [$priority, $this->serial--]);
    }
}
