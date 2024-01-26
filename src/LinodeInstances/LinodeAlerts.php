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
 * Notification thresholds.
 *
 * @property int $cpu            The percentage of CPU usage required to trigger an alert.
 *                               If the average CPU usage over two hours exceeds this value, we'll send you an alert.
 *                               Your Linode's total CPU capacity is represented as 100%, multiplied by its number of
 *                               cores.
 *                               For example, a two core Linode's CPU capacity is represented as 200%. If you want
 *                               to be alerted at 90% of a two core Linode's CPU capacity, set the alert value to `180`.
 *                               If the value is set to `0` (zero), the alert is disabled.
 * @property int $network_in     The amount of incoming traffic, in Mbit/s, required to trigger an alert. If the
 *                               average incoming traffic over two hours exceeds this value, we'll send you an
 *                               alert. If this is set to `0` (zero), the alert is disabled.
 * @property int $network_out    The amount of outbound traffic, in Mbit/s, required to trigger an alert. If the
 *                               average outbound traffic over two hours exceeds this value, we'll send you an
 *                               alert. If this is set to `0` (zero), the alert is disabled.
 * @property int $transfer_quota The percentage of network transfer that may be used before an alert is triggered.
 *                               When this value is exceeded, we'll alert you. If this is set to `0` (zero), the alert is
 *                               disabled.
 * @property int $io             The amount of disk IO operation per second required to trigger an alert. If the
 *                               average disk IO over two hours exceeds this value, we'll send you an alert. If set
 *                               to `0`, this alert is disabled.
 */
class LinodeAlerts extends Entity {}
