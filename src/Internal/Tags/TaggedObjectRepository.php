<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal\Tags;

use Linode\Entity\Entity;
use Linode\Entity\Linode;
use Linode\Internal\AbstractRepository;
use Linode\LinodeClient;
use Linode\Repository\Tags\TaggedObjectRepositoryInterface;

/**
 * {@inheritdoc}
 */
class TaggedObjectRepository extends AbstractRepository implements TaggedObjectRepositoryInterface
{
    /** @var string The ID of the Tag we are accessing Objects for. */
    protected $tag;

    /**
     * {@inheritdoc}
     */
    public function __construct(LinodeClient $client, string $tag)
    {
        parent::__construct($client);

        $this->tag = $tag;
    }

    /**
     * {@inheritdoc}
     */
    protected function getBaseUri(): string
    {
        return sprintf('/tags/%s', $this->tag);
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
    protected function jsonToEntity(array $json): Entity
    {
        return new Linode($this->client, $json);
    }
}
