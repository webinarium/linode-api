<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\ObjectStorage;

use Linode\Entity;

/**
 * Limited Access Keys restrict this Object Storage key's access to only the
 * bucket(s) declared in this array and define their bucket-level permissions.
 *
 * @property string $cluster     The Object Storage cluster where a bucket to which the key is granting access is
 *                               hosted.
 * @property string $bucket_name The unique label of the bucket to which the key will grant limited access.
 * @property string $permissions This Limited Access Key's permissions for the selected bucket.
 */
class LimitedAccessKey extends Entity
{
    public const PERMISSIONS_READ_WRITE = 'read_write';
    public const PERMISSIONS_READ_ONLY  = 'read_only';
}
