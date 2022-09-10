<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity\NodeBalancers;

use Linode\Entity\Entity;
use Linode\Entity\TimeValue;

/**
 * Stats data for a NodeBalancer.
 *
 * @property array|TimeValue[] $connections An array of key/value pairs representing unix timestamp and
 *                                          reading for connections to this NodeBalancer.
 * @property NodeTraffic       $traffic     Traffic statistics for this NodeBalancer.
 */
class NodeBalancerStatsData extends Entity
{
    /**
     * {@inheritdoc}
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'connections' => array_map(fn ($data) => new TimeValue((int) $data[0], (float) $data[1]), $this->data[$name]),
            'traffic'     => new NodeTraffic($this->client, $this->data[$name]),
            default       => parent::__get($name),
        };
    }
}
