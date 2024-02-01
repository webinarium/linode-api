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
 * @property string      $range        The IPv6 range of addresses in this pool.
 * @property int         $prefix       The prefix length of the address, denoting how many addresses can be assigned from
 *                                     this range calculated as 2 <sup>128-prefix</sup>.
 * @property string      $region       The region for this range of IPv6 addresses.
 * @property null|string $route_target The last address in this block of IPv6 addresses.
 */
class IPv6Range extends Entity
{
    // Available fields.
    public const FIELD_RANGE        = 'range';
    public const FIELD_PREFIX       = 'prefix';
    public const FIELD_REGION       = 'region';
    public const FIELD_ROUTE_TARGET = 'route_target';
}
