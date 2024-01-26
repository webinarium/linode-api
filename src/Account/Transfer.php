<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Account;

use Linode\Entity;

/**
 * An object representing your network utilization for the current month, in
 * Gigabytes.
 *
 * @property int $quota    The amount of network usage allowed this billing cycle.
 * @property int $used     The amount of network usage you have used this billing cycle.
 * @property int $billable The amount of your transfer pool that is billable this billing cycle.
 */
class Transfer extends Entity
{
    // Available fields.
    public const FIELD_QUOTA    = 'quota';
    public const FIELD_USED     = 'used';
    public const FIELD_BILLABLE = 'billable';
}
