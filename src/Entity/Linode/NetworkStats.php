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
use Linode\Entity\TimeValue;

/**
 * Network statistics.
 *
 * Graph data is in "[timestamp, reading]" array format.
 * Timestamp is a UNIX timestamp in EST.
 *
 * @property array|TimeValue[] $in          Input stats, measured in bits/s (bits/second).
 * @property array|TimeValue[] $out         Output stats, measured in bits/s (bits/second).
 * @property array|TimeValue[] $private_in  Private IP input statistics, measured in bits/s (bits/second).
 * @property array|TimeValue[] $private_out Private IP output statistics, measured in bits/s (bits/second).
 */
class NetworkStats extends Entity
{
    public function __get(string $name): ?array
    {
        if (array_key_exists($name, $this->data)) {
            return array_map(static fn ($data) => new TimeValue((int) $data[0], (float) $data[1]), $this->data[$name]);
        }

        return null;
    }
}
