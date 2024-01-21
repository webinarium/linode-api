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
use Linode\Entity\Linode;
use Linode\Repository\LinodeRepositoryInterface;

class LinodeRepository extends AbstractRepository implements LinodeRepositoryInterface
{
    public function create(array $parameters): Linode
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_POST, $this->getBaseUri(), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Linode($this->client, $json);
    }

    public function update(int $id, array $parameters): Linode
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_PUT, sprintf('%s/%s', $this->getBaseUri(), $id), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Linode($this->client, $json);
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

    public function rebuild(int $id, array $parameters): Linode
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_POST, sprintf('%s/%s/rebuild', $this->getBaseUri(), $id), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Linode($this->client, $json);
    }

    public function resize(int $id, string $type): void
    {
        $parameters = [
            'type' => $type,
        ];

        $this->client->api($this->client::REQUEST_POST, sprintf('%s/%s/resize', $this->getBaseUri(), $id), $parameters);
    }

    public function mutate(int $id): void
    {
        $this->client->api($this->client::REQUEST_POST, sprintf('%s/%s/mutate', $this->getBaseUri(), $id));
    }

    public function migrate(int $id): void
    {
        $this->client->api($this->client::REQUEST_POST, sprintf('%s/%s/migrate', $this->getBaseUri(), $id));
    }

    public function boot(int $id, int $config_id = null): void
    {
        $parameters = [
            'config_id' => $config_id,
        ];

        $this->client->api($this->client::REQUEST_POST, sprintf('%s/%s/boot', $this->getBaseUri(), $id), $parameters);
    }

    public function reboot(int $id, int $config_id = null): void
    {
        $parameters = [
            'config_id' => $config_id,
        ];

        $this->client->api($this->client::REQUEST_POST, sprintf('%s/%s/reboot', $this->getBaseUri(), $id), $parameters);
    }

    public function shutdown(int $id): void
    {
        $this->client->api($this->client::REQUEST_POST, sprintf('%s/%s/shutdown', $this->getBaseUri(), $id));
    }

    public function rescue(int $id, array $parameters): void
    {
        $this->checkParametersSupport($parameters);

        $this->client->api($this->client::REQUEST_POST, sprintf('%s/%s/rescue', $this->getBaseUri(), $id), $parameters);
    }

    public function enableBackups(int $id): void
    {
        $this->client->api($this->client::REQUEST_POST, sprintf('%s/%s/backups/enable', $this->getBaseUri(), $id));
    }

    public function cancelBackups(int $id): void
    {
        $this->client->api($this->client::REQUEST_POST, sprintf('%s/%s/backups/cancel', $this->getBaseUri(), $id));
    }

    public function createSnapshot(int $id, string $label): Linode\Backup
    {
        $parameters = [
            'label' => $label,
        ];

        $response = $this->client->api($this->client::REQUEST_POST, sprintf('%s/%s/backups', $this->getBaseUri(), $id), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Linode\Backup($this->client, $json);
    }

    public function restoreBackup(int $source_id, int $backup_id, int $target_id, bool $overwrite = true): void
    {
        $parameters = [
            'linode_id' => $target_id,
            'overwrite' => $overwrite,
        ];

        $uri = sprintf('%s/%s/backups/%s/restore', $this->getBaseUri(), $source_id, $backup_id);

        $this->client->api($this->client::REQUEST_POST, $uri, $parameters);
    }

    public function getBackup(int $id, int $backup_id): Linode\Backup
    {
        $response = $this->client->api($this->client::REQUEST_GET, sprintf('%s/%s/backups/%s', $this->getBaseUri(), $id, $backup_id));
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Linode\Backup($this->client, $json);
    }

    public function getAllBackups(int $id): array
    {
        $response = $this->client->api($this->client::REQUEST_GET, sprintf('%s/%s/backups', $this->getBaseUri(), $id));
        $contents = $response->getBody()->getContents();

        return json_decode($contents, true);
    }

    public function getCurrentTransfer(int $id): Linode\LinodeTransfer
    {
        $response = $this->client->api($this->client::REQUEST_GET, sprintf('%s/%s/transfer', $this->getBaseUri(), $id));
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Linode\LinodeTransfer($this->client, $json);
    }

    public function getCurrentStats(int $id): Linode\LinodeStats
    {
        $response = $this->client->api($this->client::REQUEST_GET, sprintf('%s/%s/stats', $this->getBaseUri(), $id));
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Linode\LinodeStats($this->client, $json);
    }

    public function getMonthlyStats(int $id, int $year, int $month): Linode\LinodeStats
    {
        $response = $this->client->api($this->client::REQUEST_GET, sprintf('%s/%s/stats/%s/%02s', $this->getBaseUri(), $id, $year, $month));
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Linode\LinodeStats($this->client, $json);
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
            Linode::FIELD_REGION,
            Linode::FIELD_IMAGE,
            Linode::FIELD_TYPE,
            Linode::FIELD_STATUS,
            Linode::FIELD_IPV4,
            Linode::FIELD_IPV6,
            Linode::FIELD_HYPERVISOR,
            Linode::FIELD_WATCHDOG_ENABLED,
            Linode::FIELD_CREATED,
            Linode::FIELD_UPDATED,
            Linode::FIELD_GROUP,
            Linode::FIELD_TAGS,
            Linode::FIELD_SPECS,
            Linode::FIELD_ALERTS,
            Linode::FIELD_BACKUPS,
            Linode::FIELD_LINODE_ID,
            Linode::FIELD_ROOT_PASS,
            Linode::FIELD_SWAP_SIZE,
            Linode::FIELD_BOOTED,
            Linode::FIELD_PRIVATE_IP,
            Linode::FIELD_AUTHORIZED_KEYS,
            Linode::FIELD_AUTHORIZED_USERS,
            Linode::FIELD_BACKUP_ID,
            Linode::FIELD_BACKUPS_ENABLED,
            Linode::FIELD_STACKSCRIPT_ID,
            Linode::FIELD_STACKSCRIPT_DATA,
            Linode::FIELD_DEVICES,
            Linode::FIELD_DISKS,
            Linode::FIELD_CONFIGS,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new Linode($this->client, $json);
    }
}
