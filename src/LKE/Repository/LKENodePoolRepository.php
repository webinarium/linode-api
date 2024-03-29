<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\LKE\Repository;

use Linode\Entity;
use Linode\Internal\AbstractRepository;
use Linode\LinodeClient;
use Linode\LKE\LKENodePool;
use Linode\LKE\LKENodePoolRepositoryInterface;

/**
 * @codeCoverageIgnore This class was autogenerated.
 */
class LKENodePoolRepository extends AbstractRepository implements LKENodePoolRepositoryInterface
{
    /**
     * @param int $clusterId ID of the Kubernetes cluster to look up.
     */
    public function __construct(LinodeClient $client, protected int $clusterId)
    {
        parent::__construct($client);
    }

    public function postLKEClusterPools(array $parameters = []): LKENodePool
    {
        $response = $this->client->post($this->getBaseUri(), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new LKENodePool($this->client, $json);
    }

    public function putLKENodePool(int $poolId, array $parameters = []): LKENodePool
    {
        $response = $this->client->put(sprintf('%s/%s', $this->getBaseUri(), $poolId), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new LKENodePool($this->client, $json);
    }

    public function deleteLKENodePool(int $poolId): void
    {
        $this->client->delete(sprintf('%s/%s', $this->getBaseUri(), $poolId));
    }

    public function postLKEClusterPoolRecycle(int $poolId): void
    {
        $this->client->post(sprintf('%s/%s/recycle', $this->getBaseUri(), $poolId));
    }

    public function getLKEClusterAPIEndpoints(): array
    {
        $response = $this->client->get(sprintf('/lke/clusters/%s/api-endpoints', $this->getBaseUri()));
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return array_map(static fn ($data) => $data['endpoint'], $json['data']);
    }

    protected function getBaseUri(): string
    {
        return sprintf('/lke/clusters/%s/pools', $this->clusterId);
    }

    protected function getSupportedFields(): array
    {
        return [
            LKENodePool::FIELD_AUTOSCALER,
            LKENodePool::FIELD_TYPE,
            LKENodePool::FIELD_COUNT,
            LKENodePool::FIELD_DISKS,
            LKENodePool::FIELD_ID,
            LKENodePool::FIELD_NODES,
            LKENodePool::FIELD_TAGS,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new LKENodePool($this->client, $json);
    }
}
