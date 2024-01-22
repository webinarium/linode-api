<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity\ObjectStorage;

use Linode\Entity\Entity;

/**
 * A keypair used to communicate with the Object Storage S3 API.
 *
 * @property int    $id         This keypair's unique ID.
 * @property string $label      The label given to this key. For display purposes only.
 * @property string $access_key This keypair's access key. This is not secret.
 * @property string $secret_key This keypair's secret key. **Only returned on key creation**.
 */
class ObjectStorageKey extends Entity
{
    // Available fields.
    public const FIELD_ID         = 'id';
    public const FIELD_LABEL      = 'label';
    public const FIELD_ACCESS_KEY = 'access_key';
    public const FIELD_SECRET_KEY = 'secret_key';
}
