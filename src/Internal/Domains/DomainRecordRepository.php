<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal\Domains;

use Linode\Entity\Domains\DomainRecord;
use Linode\Entity\Entity;
use Linode\Internal\AbstractRepository;
use Linode\LinodeClient;
use Linode\Repository\Domains\DomainRecordRepositoryInterface;

/**
 * {@inheritdoc}
 */
class DomainRecordRepository extends AbstractRepository implements DomainRecordRepositoryInterface
{
    /** @var int The ID of the Domain we are accessing Records for. */
    protected $domainId;

    /**
     * {@inheritdoc}
     */
    public function __construct(LinodeClient $client, int $id)
    {
        parent::__construct($client);

        $this->domainId = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $parameters): DomainRecord
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_POST, $this->getBaseUri(), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new DomainRecord($this->client, $json);
    }

    /**
     * {@inheritdoc}
     */
    public function update(int $id, array $parameters): DomainRecord
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_PUT, sprintf('%s/%s', $this->getBaseUri(), $id), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new DomainRecord($this->client, $json);
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
    protected function getBaseUri(): string
    {
        return sprintf('/domains/%s/records', $this->domainId);
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedFields(): array
    {
        return [
            DomainRecord::FIELD_ID,
            DomainRecord::FIELD_TYPE,
            DomainRecord::FIELD_NAME,
            DomainRecord::FIELD_TARGET,
            DomainRecord::FIELD_TTL_SEC,
            DomainRecord::FIELD_PRIORITY,
            DomainRecord::FIELD_WEIGHT,
            DomainRecord::FIELD_SERVICE,
            DomainRecord::FIELD_PROTOCOL,
            DomainRecord::FIELD_PORT,
            DomainRecord::FIELD_TAG,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function jsonToEntity(array $json): Entity
    {
        return new DomainRecord($this->client, $json);
    }
}
