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

/**
 * Network statistics.
 *
 * Graph data is in "[timestamp, reading]" array format.
 * Timestamp is a UNIX timestamp in EST.
 *
 * @property float[][] $in          Input stats, measured in bits/s (bits/second).
 * @property float[][] $out         Output stats, measured in bits/s (bits/second).
 * @property float[][] $private_in  Private IP input statistics, measured in bits/s (bits/second).
 * @property float[][] $private_out Private IP output statistics, measured in bits/s (bits/second).
 */
class NetworkStats extends Entity {}
