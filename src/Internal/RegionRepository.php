<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal;

use Linode\Entity\Entity;
use Linode\Entity\Region;
use Linode\Repository\RegionRepositoryInterface;

class RegionRepository extends AbstractRepository implements RegionRepositoryInterface
{
    protected function getBaseUri(): string
    {
        return '/regions';
    }

    protected function getSupportedFields(): array
    {
        return [
            Region::FIELD_ID,
            Region::FIELD_COUNTRY,
            Region::FIELD_CAPABILITIES,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new Region($this->client, $json);
    }
}
