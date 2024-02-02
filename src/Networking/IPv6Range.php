<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Networking;

use Linode\Entity;

/**
 * An object representing an IPv6 range.
 *
 * @property string $range        The IPv6 address of this range.
 * @property int    $prefix       The prefix length of the address. The total number of addresses that can be
 *                                assigned from this range is calculated as 2<sup>(128 - prefix length)</sup>.
 * @property string $region       The region for this range of IPv6 addresses.
 * @property string $route_target The IPv6 SLAAC address.
 */
class IPv6Range extends Entity
{
    // Available fields.
    public const FIELD_RANGE        = 'range';
    public const FIELD_PREFIX       = 'prefix';
    public const FIELD_REGION       = 'region';
    public const FIELD_ROUTE_TARGET = 'route_target';
}
