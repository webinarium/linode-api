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
 * A disk that is part of the Backup.
 *
 * @property string $label      The Disk's label is for display purposes only.
 * @property int    $size       The size of the Disk in MB.
 * @property string $filesystem The Disk filesystem.
 */
class BackupDisk extends Entity {}
