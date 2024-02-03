<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Networking;

use Linode\Entity;

/**
 * IPv4 address configured as a 1:1 NAT.
 *
 * @property int    $vpc_id    The `id` of the VPC configured for this Interface.
 * @property int    $subnet_id The `id` of the VPC Subnet for this Interface.
 * @property string $address   The IPv4 address that is configured as a 1:1 NAT for this VPC interface.
 */
class NATConfig extends Entity {}
