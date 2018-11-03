<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity;

/**
 * A key/value pair representing unix timestamp as a key.
 *
 * @property int   $time  Unix timestamp.
 * @property float $value Custom value.
 */
class TimeValue
{
    protected $time;
    protected $value;

    /**
     * TimeValue constructor.
     *
     * @param int   $time
     * @param float $value
     */
    public function __construct(int $time, float $value)
    {
        $this->time  = $time;
        $this->value = $value;
    }

    /**
     * Checks whether the specified property exists.
     *
     * @param string $name Property name.
     *
     * @return bool
     */
    public function __isset(string $name): bool
    {
        return $name === 'time' || $name === 'value';
    }

    /**
     * Returns current value of the specified property, or `null` if the property doesn't exist.
     *
     * @param string $name Property name.
     *
     * @return null|float|int
     */
    public function __get(string $name)
    {
        if ($name === 'time') {
            return $this->time;
        }

        if ($name === 'value') {
            return $this->value;
        }

        return null;
    }
}
