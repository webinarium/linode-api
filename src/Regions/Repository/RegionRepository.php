<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Regions\Repository;

use Linode\Entity;
use Linode\Internal\AbstractRepository;
use Linode\Regions\Region;
use Linode\Regions\RegionRepositoryInterface;

/**
 * @codeCoverageIgnore This class was autogenerated.
 */
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
            Region::FIELD_STATUS,
            Region::FIELD_RESOLVERS,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new Region($this->client, $json);
    }
}
