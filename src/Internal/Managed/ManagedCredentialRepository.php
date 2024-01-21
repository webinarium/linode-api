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
use Linode\Entity\Managed\ManagedCredential;
use Linode\Internal\AbstractRepository;
use Linode\Repository\Managed\ManagedCredentialRepositoryInterface;

/**
 * {@inheritdoc}
 */
class ManagedCredentialRepository extends AbstractRepository implements ManagedCredentialRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(array $parameters): ManagedCredential
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_POST, $this->getBaseUri(), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new ManagedCredential($this->client, $json);
    }

    /**
     * {@inheritdoc}
     */
    public function update(int $id, array $parameters): ManagedCredential
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_PUT, sprintf('%s/%s', $this->getBaseUri(), $id), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new ManagedCredential($this->client, $json);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(int $id): void
    {
        $this->client->api($this->client::REQUEST_POST, sprintf('%s/%s/revoke', $this->getBaseUri(), $id));
    }

    /**
     * {@inheritdoc}
     */
    protected function getBaseUri(): string
    {
        return '/managed/credentials';
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedFields(): array
    {
        return [
            ManagedCredential::FIELD_ID,
            ManagedCredential::FIELD_LABEL,
            ManagedCredential::FIELD_USERNAME,
            ManagedCredential::FIELD_PASSWORD,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function jsonToEntity(array $json): Entity
    {
        return new ManagedCredential($this->client, $json);
    }
}
