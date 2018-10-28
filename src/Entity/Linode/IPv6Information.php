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
    public function __get(string $name)
    {
        switch ($name) {

            case 'link_local':
                return new IPAddress($this->client, $this->data['link_local']);

            case 'slaac':
                return new IPAddress($this->client, $this->data['slaac']);

            case 'global':
                return new IPv6Pool($this->client, $this->data['global']);
        }

        return parent::__get($name);
    }
}
