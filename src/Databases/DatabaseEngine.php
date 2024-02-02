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
 * Managed Database engine object.
 *
 * @property string $id                 The Managed Database engine ID in engine/version format.
 * @property string $engine             The Managed Database engine type.
 * @property string $version            The Managed Database engine version.
 * @property int    $total_disk_size_gb The total disk size of the database in GB.
 * @property int    $used_disk_size_gb  The used space of the database in GB.
 */
class DatabaseEngine extends Entity
{
    // Available fields.
    public const FIELD_ID                 = 'id';
    public const FIELD_ENGINE             = 'engine';
    public const FIELD_VERSION            = 'version';
    public const FIELD_TOTAL_DISK_SIZE_GB = 'total_disk_size_gb';
    public const FIELD_USED_DISK_SIZE_GB  = 'used_disk_size_gb';
}
