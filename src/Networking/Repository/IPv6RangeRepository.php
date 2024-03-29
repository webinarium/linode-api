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
use Linode\Networking\IPv6Range;
use Linode\Networking\IPv6RangeRepositoryInterface;

/**
 * @codeCoverageIgnore This class was autogenerated.
 */
class IPv6RangeRepository extends AbstractRepository implements IPv6RangeRepositoryInterface
{
    public function postIPv6Range(array $parameters = []): IPv6Range
    {
        $response = $this->client->post($this->getBaseUri(), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new IPv6Range($this->client, $json);
    }

    public function deleteIPv6Range(string $range): void
    {
        $this->client->delete(sprintf('%s/%s', $this->getBaseUri(), $range));
    }

    protected function getBaseUri(): string
    {
        return '/networking/ipv6/ranges';
    }

    protected function getSupportedFields(): array
    {
        return [
            IPv6Range::FIELD_RANGE,
            IPv6Range::FIELD_PREFIX,
            IPv6Range::FIELD_REGION,
            IPv6Range::FIELD_ROUTE_TARGET,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new IPv6Range($this->client, $json);
    }
}
