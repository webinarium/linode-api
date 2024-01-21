<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity;

/**
 * A Block Storage Volume associated with your Account.
 *
 * @property int      $id              The unique ID of this Volume.
 * @property string   $label           The Volume's label is for display purposes only.
 * @property string   $status          The current status of the volume (@see `STATUS_...` constants).
 * @property int      $size            The Volume's size, in GiB.
 * @property string   $region          The unique ID of this Region.
 * @property null|int $linode_id       If a Volume is attached to a specific Linode, the ID of that Linode
 *                                     will be displayed here.
 * @property string   $filesystem_path The full filesystem path for the Volume based on the Volume's label.
 *                                     Path is /dev/disk/by-id/scsi-0Linode_Volume_ + Volume label.
 * @property string   $created         When this Volume was created.
 * @property string   $updated         When this Volume was last updated.
 * @property string[] $tags            An array of Tags applied to this object. Tags are for organizational
 *                                     purposes only.
 */
class Volume extends Entity
{
    // Available fields.
    public const FIELD_ID        = 'id';
    public const FIELD_LABEL     = 'label';
    public const FIELD_STATUS    = 'status';
    public const FIELD_SIZE      = 'size';
    public const FIELD_REGION    = 'region';
    public const FIELD_LINODE_ID = 'linode_id';
    public const FIELD_TAGS      = 'tags';

    // Extra field for create/update operations.
    public const FIELD_CONFIG_ID = 'config_id';

    // Volume statuses.
    public const STATUS_CREATING        = 'creating';
    public const STATUS_ACTIVE          = 'active';
    public const STATUS_RESIZING        = 'resizing';
    public const STATUS_CONTACT_SUPPORT = 'contact_support';
}
