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
 * A Rule can have up to 255 addresses or networks listed across its IPv4 and IPv6
 * arrays. A network and a single IP are treated as equivalent when accounting for
 * this limit.
 *
 * @property string[] $ipv4 A list of IPv4 addresses or networks.
 * @property string[] $ipv6 A list of IPv6 addresses or networks.
 */
class FirewallRuleAddresses extends Entity {}
