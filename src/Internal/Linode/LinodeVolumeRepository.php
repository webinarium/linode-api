<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal\Linode;

use Linode\Entity\Entity;
use Linode\Entity\Volume;
use Linode\Internal\AbstractRepository;
use Linode\LinodeClient;
use Linode\Repository\Linode\LinodeVolumeRepositoryInterface;

/**
 * {@inheritdoc}
 */
class LinodeVolumeRepository extends AbstractRepository implements LinodeVolumeRepositoryInterface
{
    /** @var int ID of the Linode to look up. */
    protected $linodeId;

    /**
     * {@inheritdoc}
     */
    public function __construct(LinodeClient $client, int $id)
    {
        parent::__construct($client);

        $this->linodeId = $id;
    }

    /**
     * {@inheritdoc}
     */
    protected function getBaseUri(): string
    {
        return sprintf('/linode/instances/%s/volumes', $this->linodeId);
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedFields(): array
    {
        return [
            Volume::FIELD_ID,
            Volume::FIELD_LABEL,
            Volume::FIELD_STATUS,
            Volume::FIELD_SIZE,
            Volume::FIELD_REGION,
            Volume::FIELD_LINODE_ID,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function jsonToEntity(array $json): Entity
    {
        return new Volume($this->client, $json);
    }
}
