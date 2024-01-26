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

use Linode\Account\Transfer;
use Linode\Entity;
use Linode\Internal\AbstractRepository;
use Linode\LinodeInstances\Linode;
use Linode\LinodeInstances\LinodeRepositoryInterface;
use Linode\LinodeInstances\LinodeStats;
use Linode\Volumes\Volume;

/**
 * @codeCoverageIgnore This class was autogenerated.
 */
class LinodeRepository extends AbstractRepository implements LinodeRepositoryInterface
{
    public function createLinodeInstance(array $parameters = []): Linode
    {
        $response = $this->client->post($this->getBaseUri(), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Linode($this->client, $json);
    }

    public function updateLinodeInstance(int $linodeId, array $parameters = []): Linode
    {
        $response = $this->client->put(sprintf('%s/%s', $this->getBaseUri(), $linodeId), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Linode($this->client, $json);
    }

    public function deleteLinodeInstance(int $linodeId): void
    {
        $this->client->delete(sprintf('%s/%s', $this->getBaseUri(), $linodeId));
    }

    public function bootLinodeInstance(int $linodeId, array $parameters = []): void
    {
        $this->client->post(sprintf('%s/%s/boot', $this->getBaseUri(), $linodeId), $parameters);
    }

    public function cloneLinodeInstance(int $linodeId, array $parameters = []): void
    {
        $this->client->post(sprintf('%s/%s/clone', $this->getBaseUri(), $linodeId), $parameters);
    }

    public function migrateLinodeInstance(int $linodeId, array $parameters = []): void
    {
        $this->client->post(sprintf('%s/%s/migrate', $this->getBaseUri(), $linodeId), $parameters);
    }

    public function mutateLinodeInstance(int $linodeId, array $parameters = []): void
    {
        $this->client->post(sprintf('%s/%s/mutate', $this->getBaseUri(), $linodeId), $parameters);
    }

    public function rebootLinodeInstance(int $linodeId, array $parameters = []): void
    {
        $this->client->post(sprintf('%s/%s/reboot', $this->getBaseUri(), $linodeId), $parameters);
    }

    public function rebuildLinodeInstance(int $linodeId, array $parameters = []): Linode
    {
        $response = $this->client->post(sprintf('%s/%s/rebuild', $this->getBaseUri(), $linodeId), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Linode($this->client, $json);
    }

    public function rescueLinodeInstance(int $linodeId, array $parameters = []): void
    {
        $this->client->post(sprintf('%s/%s/rescue', $this->getBaseUri(), $linodeId), $parameters);
    }

    public function resizeLinodeInstance(int $linodeId, array $parameters = []): void
    {
        $this->client->post(sprintf('%s/%s/resize', $this->getBaseUri(), $linodeId), $parameters);
    }

    public function shutdownLinodeInstance(int $linodeId): void
    {
        $this->client->post(sprintf('%s/%s/shutdown', $this->getBaseUri(), $linodeId));
    }

    public function getLinodeStats(int $linodeId): LinodeStats
    {
        $response = $this->client->get(sprintf('%s/%s/stats', $this->getBaseUri(), $linodeId));
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new LinodeStats($this->client, $json);
    }

    public function getLinodeStatsByYearMonth(int $linodeId, int $year, int $month): LinodeStats
    {
        $response = $this->client->get(sprintf('%s/%s/stats/%s/%s', $this->getBaseUri(), $linodeId, $year, $month));
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new LinodeStats($this->client, $json);
    }

    public function getLinodeTransfer(int $linodeId): Transfer
    {
        $response = $this->client->get(sprintf('%s/%s/transfer', $this->getBaseUri(), $linodeId));
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Transfer($this->client, $json);
    }

    public function getLinodeVolumes(int $linodeId): array
    {
        $response = $this->client->get(sprintf('%s/%s/volumes', $this->getBaseUri(), $linodeId));
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return array_map(fn ($data) => new Volume($this->client, $data), $json['data']);
    }

    protected function getBaseUri(): string
    {
        return '/linode/instances';
    }

    protected function getSupportedFields(): array
    {
        return [
            Linode::FIELD_ID,
            Linode::FIELD_LABEL,
            Linode::FIELD_GROUP,
            Linode::FIELD_TAGS,
            Linode::FIELD_REGION,
            Linode::FIELD_TYPE,
            Linode::FIELD_IMAGE,
            Linode::FIELD_STATUS,
            Linode::FIELD_HYPERVISOR,
            Linode::FIELD_CREATED,
            Linode::FIELD_UPDATED,
            Linode::FIELD_WATCHDOG_ENABLED,
            Linode::FIELD_IPV4,
            Linode::FIELD_IPV6,
            Linode::FIELD_SPECS,
            Linode::FIELD_ALERTS,
            Linode::FIELD_BACKUPS,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new Linode($this->client, $json);
    }
}
