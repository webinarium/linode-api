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
 * IPv4 addresses configured for VPC interface.
 *
 * @property string $vpc     The VPC Subnet IPv4 address for this Interface.
 * @property string $nat_1_1 The 1:1 NAT IPv4 address, used to associate a public IPv4 address with the VPC
 *                           Subnet IPv4 address assigned to this Interface.
 */
class IPv4Config extends Entity {}
