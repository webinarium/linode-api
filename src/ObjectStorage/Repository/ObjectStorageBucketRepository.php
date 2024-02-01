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
use Linode\LinodeClient;
use Linode\ObjectStorage\ObjectStorageBucket;
use Linode\ObjectStorage\ObjectStorageBucketRepositoryInterface;
use Linode\ObjectStorage\ObjectStorageObject;

/**
 * @codeCoverageIgnore This class was autogenerated.
 */
class ObjectStorageBucketRepository extends AbstractRepository implements ObjectStorageBucketRepositoryInterface
{
    /**
     * @param string $clusterId The ID of the cluster this bucket exists in.
     */
    public function __construct(LinodeClient $client, protected string $clusterId)
    {
        parent::__construct($client);
    }

    public function createObjectStorageBucket(array $parameters = []): ObjectStorageBucket
    {
        $response = $this->client->post('/object-storage/buckets', $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new ObjectStorageBucket($this->client, $json);
    }

    public function deleteObjectStorageBucket(string $bucket): void
    {
        $this->client->delete(sprintf('%s/%s', $this->getBaseUri(), $bucket));
    }

    public function modifyObjectStorageBucketAccess(string $bucket, array $parameters = []): void
    {
        $this->client->post(sprintf('%s/%s/access', $this->getBaseUri(), $bucket), $parameters);
    }

    public function getObjectStorageBucketContent(string $bucket): array
    {
        $response = $this->client->get(sprintf('%s/%s/object-list', $this->getBaseUri(), $bucket));
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return array_map(fn ($data) => new ObjectStorageObject($this->client, $data), $json['data']);
    }

    public function createObjectStorageObjectURL(string $bucket, array $parameters = []): string
    {
        $response = $this->client->post(sprintf('%s/%s/object-url', $this->getBaseUri(), $bucket), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return $json['url'];
    }

    public function cancelObjectStorage(): void
    {
        $this->client->post('/object-storage/cancel');
    }

    protected function getBaseUri(): string
    {
        return sprintf('/object-storage/buckets/%s', $this->clusterId);
    }

    protected function getSupportedFields(): array
    {
        return [
            ObjectStorageBucket::FIELD_CREATED,
            ObjectStorageBucket::FIELD_CLUSTER,
            ObjectStorageBucket::FIELD_LABEL,
            ObjectStorageBucket::FIELD_HOSTNAME,
            ObjectStorageBucket::FIELD_SIZE,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new ObjectStorageBucket($this->client, $json);
    }
}
