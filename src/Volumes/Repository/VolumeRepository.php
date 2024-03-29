<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Volumes\Repository;

use Linode\Entity;
use Linode\Internal\AbstractRepository;
use Linode\Volumes\Volume;
use Linode\Volumes\VolumeRepositoryInterface;

/**
 * @codeCoverageIgnore This class was autogenerated.
 */
class VolumeRepository extends AbstractRepository implements VolumeRepositoryInterface
{
    public function createVolume(array $parameters = []): Volume
    {
        $response = $this->client->post($this->getBaseUri(), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Volume($this->client, $json);
    }

    public function updateVolume(int $volumeId, array $parameters = []): Volume
    {
        $response = $this->client->put(sprintf('%s/%s', $this->getBaseUri(), $volumeId), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Volume($this->client, $json);
    }

    public function deleteVolume(int $volumeId): void
    {
        $this->client->delete(sprintf('%s/%s', $this->getBaseUri(), $volumeId));
    }

    public function attachVolume(int $volumeId, array $parameters = []): Volume
    {
        $response = $this->client->post(sprintf('%s/%s/attach', $this->getBaseUri(), $volumeId), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Volume($this->client, $json);
    }

    public function cloneVolume(int $volumeId, array $parameters = []): Volume
    {
        $response = $this->client->post(sprintf('%s/%s/clone', $this->getBaseUri(), $volumeId), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Volume($this->client, $json);
    }

    public function detachVolume(int $volumeId): void
    {
        $this->client->post(sprintf('%s/%s/detach', $this->getBaseUri(), $volumeId));
    }

    public function resizeVolume(int $volumeId, array $parameters = []): Volume
    {
        $response = $this->client->post(sprintf('%s/%s/resize', $this->getBaseUri(), $volumeId), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Volume($this->client, $json);
    }

    protected function getBaseUri(): string
    {
        return '/volumes';
    }

    protected function getSupportedFields(): array
    {
        return [
            Volume::FIELD_ID,
            Volume::FIELD_LABEL,
            Volume::FIELD_STATUS,
            Volume::FIELD_SIZE,
            Volume::FIELD_REGION,
            Volume::FIELD_LINODE_ID,
            Volume::FIELD_LINODE_LABEL,
            Volume::FIELD_FILESYSTEM_PATH,
            Volume::FIELD_CREATED,
            Volume::FIELD_UPDATED,
            Volume::FIELD_TAGS,
            Volume::FIELD_HARDWARE_TYPE,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new Volume($this->client, $json);
    }
}
