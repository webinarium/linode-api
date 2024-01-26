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
 * Input/Output statistics.
 *
 * Graph data is in "[timestamp, reading]" array format.
 * Timestamp is a UNIX timestamp in EST.
 *
 * @property float[][] $io   Block/s written.
 * @property float[][] $swap Block/s written.
 */
class IOStats extends Entity {}
