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

/**
 * @property IPv4Information $ipv4
 * @property IPv6Information $ipv6
 */
class NetworkInformation extends Entity
{
    /**
     * {@inheritdoc}
     */
    public function __get(string $name)
    {
        switch ($name) {

            case 'ipv4':
                return new IPv4Information($this->client, $this->data['ipv4']);

            case 'ipv6':
                return new IPv6Information($this->client, $this->data['ipv6']);
        }

        return parent::__get($name);
    }
}
