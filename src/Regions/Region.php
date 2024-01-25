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
 * An area where Linode services are available.
 *
 * @property string   $id           The unique ID of this Region.
 * @property string   $country      The country where this Region resides.
 * @property string[] $capabilities A list of capabilities of this region.
 */
class Region extends Entity
{
    // Available fields.
    public const FIELD_ID           = 'id';
    public const FIELD_COUNTRY      = 'country';
    public const FIELD_CAPABILITIES = 'capabilities';
}
