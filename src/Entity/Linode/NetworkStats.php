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
 * Network statistics.
 *
 * Graph data is in "[timestamp, reading]" array format.
 * Timestamp is a UNIX timestamp in EST.
 *
 * @property int[][] $in          Input stats, measured in bits/s (bits/second).
 * @property int[][] $out         Output stats, measured in bits/s (bits/second).
 * @property int[][] $private_in  Private IP input statistics, measured in bits/s (bits/second).
 * @property int[][] $private_out Private IP output statistics, measured in bits/s (bits/second).
 */
class NetworkStats extends Entity
{
}
