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
 * A disk that is a part of a Backup.
 *
 * @property int    $size       The Disk size in bytes.
 * @property string $filesystem The Disk filesystem (@see `Disk::FILESYSTEM_...` constants).
 * @property string $label      The Disk label.
 */
class BackupDisk extends Entity {}
