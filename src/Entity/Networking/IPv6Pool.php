<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity\Networking;

use Linode\Entity\Entity;

/**
 * An object representing an IPv6 pool.
 *
 * @property string $range  The IPv6 pool.
 * @property int    $prefix The prefix length of the address, denoting which addresses can be
 *                          assigned from this pool.
 * @property string $region A pool of IPv6 addresses that are routed to all of
 *                          your Linodes in a single Region. Any Linode you own may bring up any
 *                          address in this pool at any time, with no external configuration
 *                          required.
 */
class IPv6Pool extends Entity
{
    // Available fields.
    public const FIELD_RANGE  = 'range';
    public const FIELD_PREFIX = 'prefix';
    public const FIELD_REGION = 'region';
}
