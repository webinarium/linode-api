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
use Linode\Entity\TimeValue;

/**
 * CPU, IO, IPv4, and IPv6 statistics.
 *
 * Graph data, if available, is in "[timestamp, reading]" array format.
 * Timestamp is a UNIX timestamp in EST.
 *
 * @property string            $title The title for this data set.
 * @property array|TimeValue[] $cpu   Percentage of CPU used.
 * @property IOStats           $io    Input/Output statistics.
 * @property NetworkStats      $netv4 IPv4 statistics.
 * @property NetworkStats      $netv6 IPv6 statistics.
 */
class LinodeStats extends Entity
{
    /**
     * {@inheritdoc}
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'cpu'   => array_map(fn ($data) => new TimeValue((int) $data[0], (float) $data[1]), $this->data['cpu']),
            'io'    => new IOStats($this->client, $this->data['io']),
            'netv4' => new NetworkStats($this->client, $this->data['netv4']),
            'netv6' => new NetworkStats($this->client, $this->data['netv6']),
            default => parent::__get($name),
        };
    }
}
