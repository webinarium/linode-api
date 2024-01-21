<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity\NodeBalancers;

use Linode\Entity\Entity;
use Linode\Entity\TimeValue;

/**
 * Traffic statistics for a NodeBalancer.
 *
 * @property array|TimeValue[] $in  An array of key/value pairs representing unix timestamp and
 *                                  reading for inbound traffic.
 * @property array|TimeValue[] $out An array of key/value pairs representing unix timestamp and
 *                                  reading for outbound traffic.
 */
class NodeTraffic extends Entity
{
    public function __get(string $name): ?array
    {
        if (array_key_exists($name, $this->data)) {
            return array_map(static fn ($data) => new TimeValue((int) $data[0], (float) $data[1]), $this->data[$name]);
        }

        return null;
    }
}
