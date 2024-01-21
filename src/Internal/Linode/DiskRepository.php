<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal\Linode;

use Linode\Entity\Entity;
use Linode\Entity\Linode\Disk;
use Linode\Internal\AbstractRepository;
use Linode\LinodeClient;
use Linode\Repository\Linode\DiskRepositoryInterface;

/**
 * {@inheritdoc}
 */
class DiskRepository extends AbstractRepository implements DiskRepositoryInterface
{
    /**
     * {@inheritdoc}
     *
     * @param int $linodeId The ID of the Linode whose Disk to look up
     */
    public function __construct(LinodeClient $client, protected int $linodeId)
    {
        parent::__construct($client);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $parameters): Disk
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_POST, $this->getBaseUri(), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Disk($this->client, $json);
    }

    /**
     * {@inheritdoc}
     */
    public function update(int $id, array $parameters): Disk
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_PUT, sprintf('%s/%s', $this->getBaseUri(), $id), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Disk($this->client, $json);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(int $id): void
    {
        $this->client->api($this->client::REQUEST_DELETE, sprintf('%s/%s', $this->getBaseUri(), $id));
    }

    /**
     * {@inheritdoc}
     */
    public function resize(int $id, int $size): void
    {
        $parameters = [
            'size' => $size,
        ];

        $this->client->api($this->client::REQUEST_POST, sprintf('%s/%s/resize', $this->getBaseUri(), $id), $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function resetPassword(int $id, string $password): void
    {
        $parameters = [
            'password' => $password,
        ];

        $this->client->api($this->client::REQUEST_POST, sprintf('%s/%s/password', $this->getBaseUri(), $id), $parameters);
    }

    /**
     * {@inheritdoc}
     */
    protected function getBaseUri(): string
    {
        return sprintf('/linode/instances/%s/disks', $this->linodeId);
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedFields(): array
    {
        return [
            Disk::FIELD_ID,
            Disk::FIELD_LABEL,
            Disk::FIELD_STATUS,
            Disk::FIELD_SIZE,
            Disk::FIELD_FILESYSTEM,
            Disk::FIELD_CREATED,
            Disk::FIELD_UPDATED,
            Disk::FIELD_READ_ONLY,
            Disk::FIELD_IMAGE,
            Disk::FIELD_ROOT_PASS,
            Disk::FIELD_AUTHORIZED_KEYS,
            Disk::FIELD_AUTHORIZED_USERS,
            Disk::FIELD_STACKSCRIPT_ID,
            Disk::FIELD_STACKSCRIPT_DATA,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function jsonToEntity(array $json): Entity
    {
        return new Disk($this->client, $json);
    }
}
