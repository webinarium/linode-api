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
 * An Object Storage Bucket. This should be accessed primarily through the S3 API;
 * click here for more information.
 *
 * @property string $created  When this bucket was created.
 * @property string $cluster  The ID of the Object Storage Cluster this bucket is in.
 * @property string $label    The name of this bucket.
 * @property string $hostname The hostname where this bucket can be accessed. This hostname can be accessed
 *                            through a browser if the bucket is made public.
 * @property int    $size     The size of the bucket in bytes.
 * @property int    $objects  The number of objects stored in this bucket.
 */
class ObjectStorageBucket extends Entity
{
    // Available fields.
    public const FIELD_CREATED  = 'created';
    public const FIELD_CLUSTER  = 'cluster';
    public const FIELD_LABEL    = 'label';
    public const FIELD_HOSTNAME = 'hostname';
    public const FIELD_SIZE     = 'size';
    public const FIELD_OBJECTS  = 'objects';

    // Extra fields for POST/PUT requests.
    public const FIELD_CORS_ENABLED = 'cors_enabled';
    public const FIELD_ACL          = 'acl';
    public const FIELD_METHOD       = 'method';
    public const FIELD_NAME         = 'name';
    public const FIELD_CONTENT_TYPE = 'content_type';
    public const FIELD_EXPIRES_IN   = 'expires_in';
}
