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
 * An Object Storage Cluster.
 *
 * @property string $id                 The unique ID for this cluster.
 * @property string $domain             The base URL for this cluster, used for connecting with third-party clients.
 * @property string $status             This cluster's status (@see `STATUS_...` constants).
 * @property string $region             The region this cluster is located in.
 * @property string $static_site_domain The base URL for this cluster used when hosting static sites.
 */
class ObjectStorageCluster extends Entity
{
    // Available fields.
    public const FIELD_ID          = 'id';
    public const FIELD_DOMAIN      = 'domain';
    public const FIELD_STATUS      = 'status';
    public const FIELD_REGION      = 'region';
    public const FIELD_SITE_DOMAIN = 'static_site_domain';

    // Cluster statuses.
    public const STATUS_AVAILABLE   = 'available';
    public const STATUS_UNAVAILABLE = 'unavailable';
}
