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
 * Public Image object.
 *
 * @property string      $id          The unique ID of this Image.
 * @property string      $label       A short description of the Image.
 * @property null|string $vendor      The upstream distribution vendor. `None` for private Images.
 * @property string      $description A detailed description of this Image.
 * @property bool        $is_public   True if the Image is public.
 * @property int         $size        The minimum size this Image needs to deploy. Size is in MB.
 * @property string      $created     When this Image was created.
 * @property string      $created_by  The name of the User who created this Image, or "linode" for official Images.
 * @property bool        $deprecated  Whether or not this Image is deprecated. Will only be true for deprecated public
 *                                    Images.
 * @property string      $type        How the Image was created. Manual Images can be created at any time. "Automatic"
 *                                    Images are created automatically from a deleted Linode.
 * @property string      $expiry      Only Images created automatically (from a deleted Linode; type=automatic) will
 *                                    expire.
 * @property string      $eol         The date of the image's planned end of life. Some images, like custom private
 *                                    images, will not have an end of life date. In that case this field will be `None`.
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
    public const FIELD_CREATED     = 'created';
    public const FIELD_CREATED_BY  = 'created_by';
    public const FIELD_DEPRECATED  = 'deprecated';
    public const FIELD_TYPE        = 'type';
    public const FIELD_EXPIRY      = 'expiry';
    public const FIELD_EOL         = 'eol';

    // Extra fields for POST/PUT requests.
    public const FIELD_DISK_ID = 'disk_id';

    // `FIELD_TYPE` values.
    public const TYPE_MANUAL    = 'manual';
    public const TYPE_AUTOMATIC = 'automatic';
}
