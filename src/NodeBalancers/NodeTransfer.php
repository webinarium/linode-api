<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\NodeBalancers;

use Linode\Entity;

/**
 * Information about the amount of transfer this NodeBalancer has had so far this month.
 *
 * @property null|float $in    The total outbound transfer, in MB, used for this NodeBalancer this month.
 * @property null|float $out   The total inbound transfer, in MB, used for this NodeBalancer this month.
 * @property null|float $total The total transfer, in MB, used by this NodeBalancer this month.
 */
class NodeTransfer extends Entity {}
