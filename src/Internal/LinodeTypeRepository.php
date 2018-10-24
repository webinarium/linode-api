<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal;

use Linode\Entity\Entity;
use Linode\Entity\LinodeType;
use Linode\Repository\LinodeTypeRepositoryInterface;

/**
 * {@inheritdoc}
 */
class LinodeTypeRepository extends AbstractRepository implements LinodeTypeRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    protected function getBaseUri(): string
    {
        return '/linode/types';
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedFields(): array
    {
        return [
            LinodeType::FIELD_ID,
            LinodeType::FIELD_LABEL,
            LinodeType::FIELD_CLASS,
            LinodeType::FIELD_DISK,
            LinodeType::FIELD_MEMORY,
            LinodeType::FIELD_VCPLUS,
            LinodeType::FIELD_NETWORK_OUT,
            LinodeType::FIELD_TRANSFER,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function jsonToEntity(array $json): Entity
    {
        return new LinodeType($this->client, $json);
    }
}
