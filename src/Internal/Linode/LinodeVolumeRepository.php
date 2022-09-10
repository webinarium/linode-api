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
    /**
     * {@inheritdoc}
     *
     * @param int $linodeId ID of the Linode to look up
     */
    public function __construct(LinodeClient $client, protected int $linodeId)
    {
        parent::__construct($client);
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
