<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity;

/**
 * A key/value pair representing unix timestamp as a key.
 *
 * @property int   $time  Unix timestamp.
 * @property float $value Custom value.
 */
class TimeValue
{
    /**
     * TimeValue constructor.
     */
    public function __construct(protected int $time, protected float $value)
    {
    }

    /**
     * Checks whether the specified property exists.
     *
     * @param string $name property name
     */
    public function __isset(string $name): bool
    {
        return $name === 'time' || $name === 'value';
    }

    /**
     * Returns current value of the specified property, or `null` if the property doesn't exist.
     *
     * @param string $name property name
     *
     * @return null|float|int
     */
    public function __get(string $name)
    {
        return match ($name) {
            'time'  => $this->time,
            'value' => $this->value,
            default => null,
        };
    }
}
