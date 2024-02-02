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
 * An object representing an IPv6 pool.
 *
 * @property string      $range        The IPv6 range of addresses in this pool.
 * @property int         $prefix       The prefix length of the address. The total number of addresses that can be
 *                                     assigned from this range is calculated as 2<sup>(128 - prefix length)</sup>.
 * @property string      $region       The region for this pool of IPv6 addresses.
 * @property null|string $route_target The last address in this block of IPv6 addresses.
 */
class IPv6Pool extends Entity
{
    // Available fields.
    public const FIELD_RANGE        = 'range';
    public const FIELD_PREFIX       = 'prefix';
    public const FIELD_REGION       = 'region';
    public const FIELD_ROUTE_TARGET = 'route_target';
}
