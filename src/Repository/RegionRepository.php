<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Repository;

use Linode\Entity\Entity;
use Linode\Entity\Region;

/**
 * Region repository.
 */
class RegionRepository extends AbstractRepository
{
    // Available fields.
    public const FIELD_ID      = 'id';
    public const FIELD_COUNTRY = 'country';

    /** {@inheritdoc} */
    protected const BASE_API_URI = '/regions';

    /**
     * {@inheritdoc}
     */
    protected function getSupportedFields(): array
    {
        return [
            self::FIELD_ID,
            self::FIELD_COUNTRY,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function jsonToEntity(array $json): Entity
    {
        return new Region($this->client, $json);
    }
}
