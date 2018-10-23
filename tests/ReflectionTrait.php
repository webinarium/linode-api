<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode;

/**
 * A trait to access protected parts of an object.
 */
trait ReflectionTrait
{
    /**
     * Calls specified protected method of the object.
     *
     * @param mixed  $object
     * @param string $name
     * @param array  $args
     *
     * @return mixed
     */
    public function callMethod($object, $name, array $args = [])
    {
        try {
            $reflection = new \ReflectionMethod(get_class($object), $name);
            $reflection->setAccessible(true);

            return $reflection->invokeArgs($object, $args);
        }
        catch (\ReflectionException $e) {
            return null;
        }
    }

    /**
     * Sets specified protected property of the object.
     *
     * @param mixed  $object
     * @param string $name
     * @param mixed  $value
     */
    public function setProperty($object, $name, $value)
    {
        try {
            $reflection = new \ReflectionProperty(get_class($object), $name);
            $reflection->setAccessible(true);
            $reflection->setValue($object, $value);
        }
        catch (\ReflectionException $e) {
        }
    }

    /**
     * Gets specified protected property of the object.
     *
     * @param mixed  $object
     * @param string $name
     *
     * @return mixed
     */
    public function getProperty($object, $name)
    {
        try {
            $reflection = new \ReflectionProperty(get_class($object), $name);
            $reflection->setAccessible(true);

            return $reflection->getValue($object);
        }
        catch (\ReflectionException $e) {
            return null;
        }
    }
}
