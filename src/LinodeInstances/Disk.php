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
 * Disk associated with a Linode.
 *
 * @property int    $id         This Disk's ID which must be provided for all operations impacting this Disk.
 * @property string $label      The Disk's label is for display purposes only.
 * @property string $status     A brief description of this Disk's current state. This field may change without
 *                              direct action from you, as a result of operations performed to the Disk or the
 *                              Linode containing the Disk.
 * @property int    $size       The size of the Disk in MB.
 * @property string $filesystem The Disk filesystem can be one of:
 *                              * raw - No filesystem, just a raw binary stream.
 *                              * swap - Linux swap area.
 *                              * ext3 - The ext3 journaling filesystem for Linux.
 *                              * ext4 - The ext4 journaling filesystem for Linux.
 *                              * initrd - initrd (uncompressed initrd, ext2, max 32 MB).
 * @property string $created    When this Disk was created.
 * @property string $updated    When this Disk was last updated.
 */
class Disk extends Entity
{
    // Available fields.
    public const FIELD_ID         = 'id';
    public const FIELD_LABEL      = 'label';
    public const FIELD_STATUS     = 'status';
    public const FIELD_SIZE       = 'size';
    public const FIELD_FILESYSTEM = 'filesystem';
    public const FIELD_CREATED    = 'created';
    public const FIELD_UPDATED    = 'updated';

    // Extra fields for POST/PUT requests.
    public const FIELD_READ_ONLY        = 'read_only';
    public const FIELD_IMAGE            = 'image';
    public const FIELD_AUTHORIZED_KEYS  = 'authorized_keys';
    public const FIELD_AUTHORIZED_USERS = 'authorized_users';
    public const FIELD_ROOT_PASS        = 'root_pass';
    public const FIELD_STACKSCRIPT_ID   = 'stackscript_id';
    public const FIELD_STACKSCRIPT_DATA = 'stackscript_data';

    // `FIELD_STATUS` values.
    public const STATUS_READY     = 'ready';
    public const STATUS_NOT_READY = 'not ready';
    public const STATUS_DELETING  = 'deleting';

    // `FIELD_FILESYSTEM` values.
    public const FILESYSTEM_RAW    = 'raw';
    public const FILESYSTEM_SWAP   = 'swap';
    public const FILESYSTEM_EXT3   = 'ext3';
    public const FILESYSTEM_EXT4   = 'ext4';
    public const FILESYSTEM_INITRD = 'initrd';
}
