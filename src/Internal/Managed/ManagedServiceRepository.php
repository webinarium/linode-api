<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal\Managed;

use Linode\Entity\Entity;
use Linode\Entity\Managed\ManagedService;
use Linode\Internal\AbstractRepository;
use Linode\Repository\Managed\ManagedServiceRepositoryInterface;

class ManagedServiceRepository extends AbstractRepository implements ManagedServiceRepositoryInterface
{
    public function create(array $parameters): ManagedService
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_POST, $this->getBaseUri(), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new ManagedService($this->client, $json);
    }

    public function update(int $id, array $parameters): ManagedService
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_PUT, sprintf('%s/%s', $this->getBaseUri(), $id), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new ManagedService($this->client, $json);
    }

    public function delete(int $id): void
    {
        $this->client->api($this->client::REQUEST_DELETE, sprintf('%s/%s', $this->getBaseUri(), $id));
    }

    public function disable(int $id): ManagedService
    {
        $response = $this->client->api($this->client::REQUEST_POST, sprintf('%s/%s/disable', $this->getBaseUri(), $id));
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new ManagedService($this->client, $json);
    }

    public function enable(int $id): ManagedService
    {
        $response = $this->client->api($this->client::REQUEST_POST, sprintf('%s/%s/enable', $this->getBaseUri(), $id));
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new ManagedService($this->client, $json);
    }

    public function getSshKey(): string
    {
        $response = $this->client->api($this->client::REQUEST_GET, '/managed/credentials/sshkey');
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return $json['ssh_key'];
    }

    protected function getBaseUri(): string
    {
        return '/managed/services';
    }

    protected function getSupportedFields(): array
    {
        return [
            ManagedService::FIELD_ID,
            ManagedService::FIELD_STATUS,
            ManagedService::FIELD_SERVICE_TYPE,
            ManagedService::FIELD_LABEL,
            ManagedService::FIELD_ADDRESS,
            ManagedService::FIELD_CONSULTATION_GROUP,
            ManagedService::FIELD_TIMEOUT,
            ManagedService::FIELD_BODY,
            ManagedService::FIELD_NOTES,
            ManagedService::FIELD_REGION,
            ManagedService::FIELD_CREDENTIALS,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new ManagedService($this->client, $json);
    }
}
