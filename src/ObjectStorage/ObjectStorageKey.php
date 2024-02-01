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
 * A keypair used to communicate with the Object Storage S3 API.
 *
 * @property int                $id            This keypair's unique ID
 * @property string             $label         The label given to this key. For display purposes only.
 * @property string             $access_key    This keypair's access key. This is not secret.
 * @property bool               $limited       Whether or not this key is a limited access key. Will return `false` if this key
 *                                             grants full access to all buckets on the user's account.
 * @property LimitedAccessKey[] $bucket_access Defines this key as a Limited Access Key. Limited Access Keys restrict this Object
 *                                             Storage key's access to only the bucket(s) declared in this array and define their
 *                                             bucket-level permissions.
 *                                             Limited Access Keys can:
 *                                             * list all buckets available on this Account, but cannot perform any actions on
 *                                             a bucket unless it has access to the bucket.
 *                                             * create new buckets, but do not have any access to the buckets it creates,
 *                                             unless explicitly given access to them.
 */
class ObjectStorageKey extends Entity
{
    // Available fields.
    public const FIELD_ID            = 'id';
    public const FIELD_LABEL         = 'label';
    public const FIELD_ACCESS_KEY    = 'access_key';
    public const FIELD_LIMITED       = 'limited';
    public const FIELD_BUCKET_ACCESS = 'bucket_access';
}
