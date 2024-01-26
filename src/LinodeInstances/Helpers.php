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
 * Helpers enabled when booting to this Linode Config.
 *
 * @property bool $updatedb_disabled  Disables updatedb cron job to avoid disk thrashing.
 * @property bool $distro             Helps maintain correct inittab/upstart console device.
 * @property bool $modules_dep        Creates a modules dependency file for the Kernel you run.
 * @property bool $network            Automatically configures static networking.
 * @property bool $devtmpfs_automount Populates the /dev directory early during boot without udev. Defaults to false.
 */
class Helpers extends Entity
{
    // Available fields.
    public const FIELD_UPDATEDB_DISABLED  = 'updatedb_disabled';
    public const FIELD_DISTRO             = 'distro';
    public const FIELD_MODULES_DEP        = 'modules_dep';
    public const FIELD_NETWORK            = 'network';
    public const FIELD_DEVTMPFS_AUTOMOUNT = 'devtmpfs_automount';
}
