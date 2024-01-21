<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal\Tags;

use Linode\Entity\Domains\Domain;
use Linode\Entity\Entity;
use Linode\Entity\Linode;
use Linode\Entity\Volume;
use Linode\Internal\AbstractRepository;
use Linode\LinodeClient;
use Linode\Repository\Tags\TaggedObjectRepositoryInterface;

class TaggedObjectRepository extends AbstractRepository implements TaggedObjectRepositoryInterface
{
    /**
     * @param string $tag The ID of the Tag we are accessing Objects for
     */
    public function __construct(LinodeClient $client, protected string $tag)
    {
        parent::__construct($client);
    }

    protected function getBaseUri(): string
    {
        return sprintf('/tags/%s', $this->tag);
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
            Linode::FIELD_HYPERVISOR,
            Linode::FIELD_WATCHDOG_ENABLED,
            Linode::FIELD_CREATED,
            Linode::FIELD_UPDATED,
            Linode::FIELD_GROUP,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return match ($json['type']) {
            'domain' => new Domain($this->client, $json['data']),
            'linode' => new Linode($this->client, $json['data']),
            'volume' => new Volume($this->client, $json['data']),
        };
    }
}
