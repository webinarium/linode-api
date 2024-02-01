<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\LKE;

use Linode\Entity;

/**
 * Node Pool's custom disk layout.
 *
 * @property int    $size The size of this custom disk partition in MB.
 * @property string $type This custom disk partition's filesystem type.
 */
class DiskLayout extends Entity
{
    public const TYPE_RAW  = 'raw';
    public const TYPE_EXT4 = 'ext4';
}
