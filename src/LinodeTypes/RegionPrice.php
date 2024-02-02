<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\LinodeTypes;

use Linode\Entity;

/**
 * Region-specific prices.
 *
 * @property string $id      The Region ID for these prices.
 * @property float  $hourly  Cost (in US dollars) per hour for this Region.
 * @property float  $monthly Cost (in US dollars) per month for this Region.
 */
class RegionPrice extends Entity {}
