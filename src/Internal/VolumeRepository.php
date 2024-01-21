<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal;

use Linode\Entity\Entity;
use Linode\Entity\Volume;
use Linode\Repository\VolumeRepositoryInterface;

class VolumeRepository extends AbstractRepository implements VolumeRepositoryInterface
{
    public function create(array $parameters): Volume
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_POST, $this->getBaseUri(), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Volume($this->client, $json);
    }

    public function update(int $id, array $parameters): Volume
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_PUT, sprintf('%s/%s', $this->getBaseUri(), $id), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Volume($this->client, $json);
    }

    public function delete(int $id): void
    {
        $this->client->api($this->client::REQUEST_DELETE, sprintf('%s/%s', $this->getBaseUri(), $id));
    }

    public function clone(int $id, array $parameters): void
    {
        $this->checkParametersSupport($parameters);

        $this->client->api($this->client::REQUEST_POST, sprintf('%s/%s/clone', $this->getBaseUri(), $id), $parameters);
    }

    public function resize(int $id, array $parameters): void
    {
        $this->checkParametersSupport($parameters);

        $this->client->api($this->client::REQUEST_POST, sprintf('%s/%s/resize', $this->getBaseUri(), $id), $parameters);
    }

    public function attach(int $id, array $parameters): Volume
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_POST, sprintf('%s/%s/attach', $this->getBaseUri(), $id), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Volume($this->client, $json);
    }

    public function detach(int $id): void
    {
        $this->client->api($this->client::REQUEST_POST, sprintf('%s/%s/detach', $this->getBaseUri(), $id));
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
            Volume::FIELD_CONFIG_ID,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new Volume($this->client, $json);
    }
}
