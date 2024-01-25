<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\LinodeInstances;

use Linode\Entity;

/**
 * Network transfer statistics.
 *
 * @property int $used     The amount of network transfer used by this Linode, in bytes, for the current month's billing cycle.
 * @property int $quota    The amount of network transfer this Linode adds to your transfer pool, in GB, for the current month's billing cycle.
 * @property int $billable The amount of network transfer this Linode has used, in GB, past your monthly quota.
 */
class LinodeTransfer extends Entity {}
