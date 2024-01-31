<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Managed;

use Linode\Entity;

/**
 * A stat data point.
 *
 * @property int $x A stats graph data point.
 * @property int $y A stats graph data point.
 */
class StatsData extends Entity
{
    // Available fields.
    public const FIELD_X = 'x';
    public const FIELD_Y = 'y';
}
