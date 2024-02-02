<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Regions;

use Linode\Entity;

/**
 * Compute instance availability information by Type and Region.
 *
 * @property string $region    The Region ID.
 * @property string $plan      The compute instance Type ID.
 * @property bool   $available Whether the compute instance type is available in the region.
 */
class RegionAvailability extends Entity
{
    // Available fields.
    public const FIELD_REGION    = 'region';
    public const FIELD_PLAN      = 'plan';
    public const FIELD_AVAILABLE = 'available';
}
