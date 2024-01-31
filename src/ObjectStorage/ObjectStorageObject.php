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
 * An Object in Object Storage, or a "prefix" that contains one or more objects when
 * a `delimiter` is used.
 *
 * @property string      $name          The name of this object or prefix.
 * @property string      $etag          An MD-5 hash of the object. `null` if this object represents a prefix.
 * @property string      $last_modified The date and time this object was last modified. `null` if this object represents
 *                                      a prefix.
 * @property string      $owner         The owner of this object, as a UUID. `null` if this object represents a prefix.
 * @property int         $size          The size of this object, in bytes. `null` if this object represents a prefix.
 * @property null|string $next_marker   Returns the value you should pass to the `marker` query parameter to get the next
 *                                      page of objects. If there is no next page, `null` will be returned.
 * @property bool        $is_truncated  Designates if there is another page of bucket objects.
 */
class ObjectStorageObject extends Entity
{
    // Available fields.
    public const FIELD_NAME          = 'name';
    public const FIELD_ETAG          = 'etag';
    public const FIELD_LAST_MODIFIED = 'last_modified';
    public const FIELD_OWNER         = 'owner';
    public const FIELD_SIZE          = 'size';
    public const FIELD_NEXT_MARKER   = 'next_marker';
    public const FIELD_IS_TRUNCATED  = 'is_truncated';
}
