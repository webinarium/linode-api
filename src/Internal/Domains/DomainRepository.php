<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal\Domains;

use Linode\Entity\Domains\Domain;
use Linode\Entity\Entity;
use Linode\Internal\AbstractRepository;
use Linode\Repository\Domains\DomainRepositoryInterface;

/**
 * {@inheritdoc}
 */
class DomainRepository extends AbstractRepository implements DomainRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(array $parameters): Domain
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_POST, $this->getBaseUri(), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Domain($this->client, $json);
    }

    /**
     * {@inheritdoc}
     */
    public function update(int $id, array $parameters): Domain
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_PUT, sprintf('%s/%s', $this->getBaseUri(), $id), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Domain($this->client, $json);
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
    public function import(string $domain, string $remote_nameserver): Domain
    {
        $parameters = [
            'domain'            => $domain,
            'remote_nameserver' => $remote_nameserver,
        ];

        $response = $this->client->api($this->client::REQUEST_POST, sprintf('%s/import', $this->getBaseUri()), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Domain($this->client, $json);
    }

    /**
     * {@inheritdoc}
     */
    protected function getBaseUri(): string
    {
        return '/domains';
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedFields(): array
    {
        return [
            Domain::FIELD_ID,
            Domain::FIELD_DOMAIN,
            Domain::FIELD_TYPE,
            Domain::FIELD_STATUS,
            Domain::FIELD_SOA_EMAIL,
            Domain::FIELD_GROUP,
            Domain::FIELD_DESCRIPTION,
            Domain::FIELD_TTL_SEC,
            Domain::FIELD_REFRESH_SEC,
            Domain::FIELD_RETRY_SEC,
            Domain::FIELD_EXPIRE_SEC,
            Domain::FIELD_MASTER_IPS,
            Domain::FIELD_AXFR_IPS,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function jsonToEntity(array $json): Entity
    {
        return new Domain($this->client, $json);
    }
}
