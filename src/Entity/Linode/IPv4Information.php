<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity\Linode;

use Linode\Entity\Entity;
use Linode\Entity\Networking\IPAddress;

/**
 * @property array|IPAddress[] $public
 * @property array|IPAddress[] $private
 * @property array|IPAddress[] $shared
 */
class IPv4Information extends Entity
{
    /**
     * {@inheritdoc}
     */
    public function __get(string $name)
    {
        if (array_key_exists($name, $this->data)) {
            return array_map(function ($data) {
                return new IPAddress($this->client, $data);
            }, $this->data[$name]);
        }

        return null;
    }
}
