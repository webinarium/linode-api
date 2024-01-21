<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode;

/**
 * A trait to access protected parts of an object.
 */
trait ReflectionTrait
{
    /**
     * Calls specified protected method of the object.
     */
    public function callMethod(mixed $object, string $name, array $args = []): mixed
    {
        try {
            $reflection = new \ReflectionMethod($object::class, $name);

            return $reflection->invokeArgs($object, $args);
        } catch (\ReflectionException) {
            return null;
        }
    }

    /**
     * Sets specified protected property of the object.
     */
    public function setProperty(mixed $object, string $name, mixed $value): void
    {
        try {
            $reflection = new \ReflectionProperty($object::class, $name);
            $reflection->setValue($object, $value);
        } catch (\ReflectionException) {
        }
    }

    /**
     * Gets specified protected property of the object.
     */
    public function getProperty(mixed $object, string $name): mixed
    {
        try {
            $reflection = new \ReflectionProperty($object::class, $name);

            return $reflection->getValue($object);
        } catch (\ReflectionException) {
            return null;
        }
    }
}
