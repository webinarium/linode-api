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

/**
 * Stats for a NodeBalancer.
 *
 * @property string                $title The title for the statistics generated in this response.
 * @property NodeBalancerStatsData $data  The data returned about this NodeBalancers.
 */
class NodeBalancerStats extends Entity
{
    public function __get(string $name): mixed
    {
        return match ($name) {
            'data'  => new NodeBalancerStatsData($this->client, $this->data[$name]),
            default => parent::__get($name),
        };
    }
}
