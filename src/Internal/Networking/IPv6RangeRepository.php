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
use Linode\Entity\Networking\IPv6Range;
use Linode\Internal\AbstractRepository;
use Linode\Repository\Networking\IPv6RangeRepositoryInterface;

class IPv6RangeRepository extends AbstractRepository implements IPv6RangeRepositoryInterface
{
    protected function getBaseUri(): string
    {
        return '/networking/ipv6/ranges';
    }

    protected function getSupportedFields(): array
    {
        return [
            IPv6Range::FIELD_RANGE,
            IPv6Range::FIELD_REGION,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new IPv6Range($this->client, $json);
    }
}
