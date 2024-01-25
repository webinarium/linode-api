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
 * Information about the amount of transfer a NodeBalancer has had.
 *
 * @property float $in    The total inbound transfer, in MB.
 * @property float $out   The total outbound transfer, in MB.
 * @property float $total The total transfer, in MB.
 */
class NodeTransfer extends Entity {}
