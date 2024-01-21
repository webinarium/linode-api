<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity\Linode;

use Linode\Entity\Entity;
use Linode\Entity\Networking\IPAddress;

/**
 * @property array|IPAddress[] $public   A list of public IP Address objects belonging to this Linode.
 * @property array|IPAddress[] $private  A list of private IP Address objects belonging to this Linode.
 * @property array|IPAddress[] $shared   A list of shared IP Address objects assigned to this Linode.
 * @property array|IPAddress[] $reserved A list of reserved IP Address objects belonging to this Linode.
 */
class IPv4Information extends Entity
{
    public function __get(string $name): ?array
    {
        if (array_key_exists($name, $this->data)) {
            return array_map(fn ($data) => new IPAddress($this->client, $data), $this->data[$name]);
        }

        return null;
    }
}
