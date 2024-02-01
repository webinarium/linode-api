<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Images;

use Linode\Entity;

/**
 * Image object.
 *
 * @property string      $id          The unique ID of this Image.
 * @property string      $label       A short description of the Image.
 * @property null|string $vendor      The upstream distribution vendor. `None` for private Images.
 * @property null|string $description A detailed description of this Image.
 * @property bool        $is_public   True if the Image is a public distribution image. False if Image is private
 *                                    Account-specific Image.
 * @property int         $size        The minimum size this Image needs to deploy. Size is in MB.
 * @property string      $status      The current status of this Image. Only Images in an "available" status
 *                                    can be deployed. Images in a "creating" status are being created from
 *                                    a Linode Disk, and will become "available" shortly. Images in a
 *                                    "pending_upload" status are waiting for data to be uploaded,
 *                                    and become "available" after the upload and processing are complete.
 * @property string      $created     When this Image was created.
 * @property string      $updated     When this Image was last updated.
 * @property string      $created_by  The name of the User who created this Image, or "linode" for public Images.
 * @property bool        $deprecated  Whether or not this Image is deprecated. Will only be true for deprecated public
 *                                    Images.
 * @property string      $type        How the Image was created.
 *                                    "Manual" Images can be created at any time.
 *                                    "Automatic" Images are created automatically from a deleted Linode.
 * @property null|string $expiry      Only Images created automatically from a deleted Linode (type=automatic) will
 *                                    expire.
 * @property string      $eol         The date of the public Image's planned end of life. `None` for private Images.
 */
class Image extends Entity
{
    // Available fields.
    public const FIELD_ID          = 'id';
    public const FIELD_LABEL       = 'label';
    public const FIELD_VENDOR      = 'vendor';
    public const FIELD_DESCRIPTION = 'description';
    public const FIELD_IS_PUBLIC   = 'is_public';
    public const FIELD_SIZE        = 'size';
    public const FIELD_STATUS      = 'status';
    public const FIELD_CREATED     = 'created';
    public const FIELD_UPDATED     = 'updated';
    public const FIELD_CREATED_BY  = 'created_by';
    public const FIELD_DEPRECATED  = 'deprecated';
    public const FIELD_TYPE        = 'type';
    public const FIELD_EXPIRY      = 'expiry';
    public const FIELD_EOL         = 'eol';

    // Extra fields for POST/PUT requests.
    public const FIELD_DISK_ID = 'disk_id';

    // `FIELD_STATUS` values.
    public const STATUS_CREATING       = 'creating';
    public const STATUS_PENDING_UPLOAD = 'pending_upload';
    public const STATUS_AVAILABLE      = 'available';

    // `FIELD_TYPE` values.
    public const TYPE_MANUAL    = 'manual';
    public const TYPE_AUTOMATIC = 'automatic';
}
