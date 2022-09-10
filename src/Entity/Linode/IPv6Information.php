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
use Linode\Entity\Networking\IPv6Pool;

/**
 * @property IPAddress $link_local
 * @property IPAddress $slaac
 * @property IPv6Pool  $global
 */
class IPv6Information extends Entity
{
    /**
     * {@inheritdoc}
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'link_local' => new IPAddress($this->client, $this->data['link_local']),
            'slaac'      => new IPAddress($this->client, $this->data['slaac']),
            'global'     => new IPv6Pool($this->client, $this->data['global']),
            default      => parent::__get($name),
        };
    }
}
