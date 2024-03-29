<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\LinodeInstances\Repository;

use Linode\Entity;
use Linode\Internal\AbstractRepository;
use Linode\LinodeClient;
use Linode\LinodeInstances\LinodeConfig;
use Linode\LinodeInstances\LinodeConfigInterface;
use Linode\LinodeInstances\LinodeConfigRepositoryInterface;

/**
 * @codeCoverageIgnore This class was autogenerated.
 */
class LinodeConfigRepository extends AbstractRepository implements LinodeConfigRepositoryInterface
{
    /**
     * @param int $linodeId ID of the Linode to look up Configuration profiles for.
     */
    public function __construct(LinodeClient $client, protected int $linodeId)
    {
        parent::__construct($client);
    }

    public function addLinodeConfig(array $parameters = []): LinodeConfig
    {
        $response = $this->client->post($this->getBaseUri(), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new LinodeConfig($this->client, $json);
    }

    public function updateLinodeConfig(int $configId, array $parameters = []): LinodeConfig
    {
        $response = $this->client->put(sprintf('%s/%s', $this->getBaseUri(), $configId), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new LinodeConfig($this->client, $json);
    }

    public function deleteLinodeConfig(int $configId): void
    {
        $this->client->delete(sprintf('%s/%s', $this->getBaseUri(), $configId));
    }

    public function getLinodeConfigInterfaces(int $configId): array
    {
        $response = $this->client->get(sprintf('%s/%s/interfaces', $this->getBaseUri(), $configId));
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return array_map(fn ($data) => new LinodeConfigInterface($this->client, $data), $json);
    }

    public function getLinodeConfigInterface(int $configId, int $interfaceId): LinodeConfigInterface
    {
        $response = $this->client->get(sprintf('%s/%s/interfaces/%s', $this->getBaseUri(), $configId, $interfaceId));
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new LinodeConfigInterface($this->client, $json);
    }

    public function addLinodeConfigInterface(int $configId, array $parameters = []): LinodeConfigInterface
    {
        $response = $this->client->post(sprintf('%s/%s/interfaces', $this->getBaseUri(), $configId), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new LinodeConfigInterface($this->client, $json);
    }

    public function updateLinodeConfigInterface(int $configId, int $interfaceId, array $parameters = []): LinodeConfigInterface
    {
        $response = $this->client->put(sprintf('%s/%s/interfaces/%s', $this->getBaseUri(), $configId, $interfaceId), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new LinodeConfigInterface($this->client, $json);
    }

    public function deleteLinodeConfigInterface(int $configId, int $interfaceId): void
    {
        $this->client->delete(sprintf('%s/%s/interfaces/%s', $this->getBaseUri(), $configId, $interfaceId));
    }

    public function orderLinodeConfigInterfaces(int $configId, array $parameters = []): void
    {
        $this->client->post(sprintf('%s/%s/interfaces/order', $this->getBaseUri(), $configId), $parameters);
    }

    protected function getBaseUri(): string
    {
        return sprintf('/linode/instances/%s/configs', $this->linodeId);
    }

    protected function getSupportedFields(): array
    {
        return [
            LinodeConfig::FIELD_ID,
            LinodeConfig::FIELD_LABEL,
            LinodeConfig::FIELD_KERNEL,
            LinodeConfig::FIELD_COMMENTS,
            LinodeConfig::FIELD_MEMORY_LIMIT,
            LinodeConfig::FIELD_RUN_LEVEL,
            LinodeConfig::FIELD_VIRT_MODE,
            LinodeConfig::FIELD_INTERFACES,
            LinodeConfig::FIELD_HELPERS,
            LinodeConfig::FIELD_DEVICES,
            LinodeConfig::FIELD_ROOT_DEVICE,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new LinodeConfig($this->client, $json);
    }
}
