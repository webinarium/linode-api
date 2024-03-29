<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Networking\Repository;

use Linode\Entity;
use Linode\Internal\AbstractRepository;
use Linode\Networking\IPv6Pool;
use Linode\Networking\IPv6PoolRepositoryInterface;

/**
 * @codeCoverageIgnore This class was autogenerated.
 */
class IPv6PoolRepository extends AbstractRepository implements IPv6PoolRepositoryInterface
{
    protected function getBaseUri(): string
    {
        return '/networking/ipv6/pools';
    }

    protected function getSupportedFields(): array
    {
        return [
            IPv6Pool::FIELD_RANGE,
            IPv6Pool::FIELD_PREFIX,
            IPv6Pool::FIELD_REGION,
            IPv6Pool::FIELD_ROUTE_TARGET,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new IPv6Pool($this->client, $json);
    }
}
