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
 * Image object.
 *
 * @property string      $id          The unique ID of this Image.
 * @property string      $label       A short description of the Image. Labels cannot contain
 *                                    special characters.
 * @property null|string $vendor      The upstream distribution vendor. `None` for private Images.
 * @property null|string $description A detailed description of this Image.
 * @property bool        $is_public   `True` if the Image is public.
 * @property int         $size        The minimum size this Image needs to deploy. Size is in MB.
 * @property string      $type        How the Image was created. "Manual" images can be created at any time.
 *                                    "Automatic" images are created automatically from a deleted Linode.
 * @property bool        $deprecated  Whether or not this Image is deprecated. Will only be `true` for
 *                                    deprecated public Images.
 * @property null|string $expiry      Only Images created automatically (from a deleted Linode; type=automatic)
 *                                    will expire.
 * @property string      $created     When this Image was created.
 * @property string      $created_by  The name of the User who created this Image, or "linode" for
 *                                    official Images.
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
    public const FIELD_TYPE        = 'type';
    public const FIELD_DEPRECATED  = 'deprecated';

    // Extra field for create/update operations.
    public const FIELD_DISK_ID = 'disk_id';

    // Image types.
    public const TYPE_MANUAL    = 'manual';
    public const TYPE_AUTOMATIC = 'automatic';
}
