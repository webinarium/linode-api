<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal\Networking;

use Linode\Entity\Entity;
use Linode\Entity\Networking\IPv6Pool;
use Linode\Internal\AbstractRepository;
use Linode\Repository\Networking\IPv6PoolRepositoryInterface;

/**
 * {@inheritdoc}
 */
class IPv6PoolRepository extends AbstractRepository implements IPv6PoolRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    protected function getBaseUri(): string
    {
        return '/networking/ipv6/pools';
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedFields(): array
    {
        return [
            IPv6Pool::FIELD_RANGE,
            IPv6Pool::FIELD_REGION,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function jsonToEntity(array $json): Entity
    {
        return new IPv6Pool($this->client, $json);
    }
}
