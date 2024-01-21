<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity\Linode;

use Linode\Entity\Entity;

/**
 * Notification thresholds.
 *
 * @property int $cpu            The percentage of CPU usage required to trigger an alert. If the average CPU
 *                               usage over two hours exceeds this value, we'll send you an alert. If this is set
 *                               to 0, the alert is disabled.
 * @property int $network_in     The amount of incoming traffic, in Mbit/s, required to trigger an alert. If the
 *                               average incoming traffic over two hours exceeds this value, we'll send you an
 *                               alert. If this is set to 0 (zero), the alert is disabled.
 * @property int $network_out    The amount of outbound traffic, in Mbit/s, required to trigger an alert. If the
 *                               average outbound traffic over two hours exceeds this value, we'll send you an
 *                               alert. If this is set to 0 (zero), the alert is disabled.
 * @property int $transfer_quota The percentage of network transfer that may be used before an alert is triggered.
 *                               When this value is exceeded, we'll alert you. If this is set to 0 (zero), the alert
 *                               is disabled.
 * @property int $io             The amount of disk IO operation per second required to trigger an alert. If the
 *                               average disk IO over two hours exceeds this value, we'll send you an alert. If set
 *                               to 0, this alert is disabled.
 */
class LinodeAlerts extends Entity
{
    // Available fields.
    public const FIELD_CPU            = 'cpu';
    public const FIELD_NETWORK_IN     = 'network_in';
    public const FIELD_NETWORK_OUT    = 'network_out';
    public const FIELD_TRANSFER_QUOTA = 'transfer_quota';
    public const FIELD_IO             = 'io';
}
