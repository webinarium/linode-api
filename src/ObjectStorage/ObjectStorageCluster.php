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
 * An Object Storage Cluster.
 *
 * @property string $id                 The unique ID for this cluster.
 * @property string $domain             The base URL for this cluster, used for connecting with third-party clients.
 * @property string $status             This cluster's status.
 * @property string $region             The region where this cluster is located.
 * @property string $static_site_domain The base URL for this cluster used when hosting static sites.
 */
class ObjectStorageCluster extends Entity
{
    // Available fields.
    public const FIELD_ID                 = 'id';
    public const FIELD_DOMAIN             = 'domain';
    public const FIELD_STATUS             = 'status';
    public const FIELD_REGION             = 'region';
    public const FIELD_STATIC_SITE_DOMAIN = 'static_site_domain';

    // `FIELD_STATUS` values.
    public const STATUS_AVAILABLE   = 'available';
    public const STATUS_UNAVAILABLE = 'unavailable';
}
