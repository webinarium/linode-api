<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal\ObjectStorage;

use Linode\Entity\Entity;
use Linode\Entity\ObjectStorage\ObjectStorageCluster;
use Linode\Internal\AbstractRepository;
use Linode\Repository\ObjectStorage\ObjectStorageClusterRepositoryInterface;

class ObjectStorageClusterRepository extends AbstractRepository implements ObjectStorageClusterRepositoryInterface
{
    protected function getBaseUri(): string
    {
        return 'beta/object-storage/clusters';
    }

    protected function getSupportedFields(): array
    {
        return [
            ObjectStorageCluster::FIELD_ID,
            ObjectStorageCluster::FIELD_DOMAIN,
            ObjectStorageCluster::FIELD_STATUS,
            ObjectStorageCluster::FIELD_REGION,
            ObjectStorageCluster::FIELD_SITE_DOMAIN,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new ObjectStorageCluster($this->client, $json);
    }
}
