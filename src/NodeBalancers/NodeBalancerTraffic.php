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
 * Traffic statistics for a NodeBalancer.
 *
 * @property float[] $in  An array of key/value pairs representing unix timestamp and
 *                        reading for inbound traffic.
 * @property float[] $out An array of key/value pairs representing unix timestamp and
 *                        reading for outbound traffic.
 */
class NodeBalancerTraffic extends Entity {}
