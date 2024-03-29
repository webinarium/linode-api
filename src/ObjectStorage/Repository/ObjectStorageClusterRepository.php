<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\ObjectStorage\Repository;

use Linode\Entity;
use Linode\Internal\AbstractRepository;
use Linode\ObjectStorage\ObjectStorageCluster;
use Linode\ObjectStorage\ObjectStorageClusterRepositoryInterface;

/**
 * @codeCoverageIgnore This class was autogenerated.
 */
class ObjectStorageClusterRepository extends AbstractRepository implements ObjectStorageClusterRepositoryInterface
{
    public function getObjectStorageBuckets(): array
    {
        $response = $this->client->get('/object-storage/buckets');
        $contents = $response->getBody()->getContents();

        return json_decode($contents, true);
    }

    protected function getBaseUri(): string
    {
        return '/object-storage/clusters';
    }

    protected function getSupportedFields(): array
    {
        return [
            ObjectStorageCluster::FIELD_ID,
            ObjectStorageCluster::FIELD_DOMAIN,
            ObjectStorageCluster::FIELD_STATUS,
            ObjectStorageCluster::FIELD_REGION,
            ObjectStorageCluster::FIELD_STATIC_SITE_DOMAIN,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new ObjectStorageCluster($this->client, $json);
    }
}
