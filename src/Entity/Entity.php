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
 * An abstract read-only entity.
 */
abstract class Entity
{
    protected $data;

    /**
     * Entity constructor.
     *
     * @param array $data JSON data retrieved from Linode.
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * Checks whether the specified property exists in the entity.
     *
     * @param string $name Property name.
     *
     * @return bool
     */
    public function __isset(string $name): bool
    {
        return array_key_exists($name, $this->data);
    }

    /**
     * Returns current value of the specified property, or `null` if the property doesn't exist.
     *
     * @param string $name Property name.
     *
     * @return null|mixed
     */
    public function __get(string $name)
    {
        return $this->data[$name] ?? null;
    }

    /**
     * Converts the entity into an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
