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
 * CPU, IO, IPv4, and IPv6 statistics.
 *
 * Graph data, if available, is in "[timestamp, reading]" array format.
 * Timestamp is a UNIX timestamp in EST.
 *
 * @property string       $title The title for this data set.
 * @property int[][]      $cpu   Percentage of CPU used.
 * @property IOStats      $io    Input/Output statistics.
 * @property NetworkStats $netv4 IPv4 statistics.
 * @property NetworkStats $netv6 IPv6 statistics.
 */
class LinodeStats extends Entity
{
    /**
     * {@inheritdoc}
     */
    public function __get(string $name)
    {
        switch ($name) {

            case 'io':
                return new IOStats($this->client, $this->data['io']);

            case 'netv4':
                return new NetworkStats($this->client, $this->data['netv4']);

            case 'netv6':
                return new NetworkStats($this->client, $this->data['netv6']);
        }

        return parent::__get($name);
    }
}
