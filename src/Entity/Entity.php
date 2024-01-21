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

use Linode\LinodeClient;

/**
 * An abstract read-only entity.
 */
abstract class Entity
{
    /**
     * Entity constructor.
     *
     * @param LinodeClient $client linode API client
     * @param array        $data   JSON data retrieved from Linode
     */
    public function __construct(protected LinodeClient $client, protected array $data = []) {}

    /**
     * Checks whether the specified property exists in the entity.
     *
     * @param string $name property name
     */
    public function __isset(string $name): bool
    {
        return array_key_exists($name, $this->data);
    }

    /**
     * Returns current value of the specified property, or `null` if the property doesn't exist.
     *
     * @param string $name property name
     *
     * @return null|mixed
     */
    public function __get(string $name): mixed
    {
        return $this->data[$name] ?? null;
    }

    /**
     * Converts the entity into an array.
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
