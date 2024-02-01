<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\LinodeInstances;

use Linode\Entity;
use Linode\Networking\IPAddressV6LinkLocal;
use Linode\Networking\IPAddressV6Slaac;
use Linode\Networking\IPv6Pool;

/**
 * Information about this Linode's IPv6 addresses.
 *
 * @property IPAddressV6LinkLocal $link_local
 * @property IPAddressV6Slaac     $slaac
 * @property IPv6Pool             $global
 */
class IPv6Information extends Entity
{
    /**
     * @codeCoverageIgnore This method was autogenerated.
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'link_local' => new IPAddressV6LinkLocal($this->client, $this->data[$name]),
            'slaac'      => new IPAddressV6Slaac($this->client, $this->data[$name]),
            'global'     => new IPv6Pool($this->client, $this->data[$name]),
            default      => parent::__get($name),
        };
    }
}