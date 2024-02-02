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
 * Region-specific network utilization data.
 *
 * @property string $id       The Region ID for this network utilization data.
 * @property int    $quota    The amount of network usage allowed this billing cycle for this Region.
 * @property int    $used     The amount of network usage you have used this billing cycle for this Region.
 * @property int    $billable The amount of your transfer pool that is billable this billing cycle for this Region.
 */
class RegionTransfer extends Entity {}
