<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Regions;

use Linode\Entity;

/**
 * Region's DNS resolvers.
 *
 * @property string $ipv4 The IPv4 addresses for this region's DNS resolvers, separated by commas.
 * @property string $ipv6 The IPv6 addresses for this region's DNS resolvers, separated by commas.
 */
class Resolver extends Entity {}
