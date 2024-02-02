<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Databases;

use Linode\Entity;

/**
 * The primary and secondary hosts for the Managed Database.
 *
 * @property string $primary   The primary host for the Managed Database.
 * @property string $secondary The secondary/private network host for the Managed Database. A private network
 *                             host and a private IP can only be used to access a Database Cluster from Linodes
 *                             in the same data center and will not incur transfer costs.
 */
class DatabaseHosts extends Entity {}
