<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity\Networking;

use Linode\Entity\Entity;

/**
 * An object representing an IPv6 range.
 *
 * @property string $range  The IPv6 range.
 * @property string $region A range of IPv6 addresses routed to a single Linode in the given
 *                          Region. Your Linode is responsible for routing individual addresses
 *                          in the range, or handling traffic for all of the addresses in the
 *                          range.
 */
class IPv6Range extends Entity
{
    // Available fields.
    public const FIELD_RANGE  = 'range';
    public const FIELD_REGION = 'region';
}
