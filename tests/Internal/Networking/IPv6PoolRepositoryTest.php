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

use GuzzleHttp\Client;
use Linode\Entity\Networking\IPv6Pool;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Networking\IPv6PoolRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\Networking\IPv6PoolRepository
 */
final class IPv6PoolRepositoryTest extends TestCase
{
    use ReflectionTrait;

    protected IPv6PoolRepositoryInterface $repository;

    protected function setUp(): void
    {
        $client = new LinodeClient();

        $this->repository = new IPv6PoolRepository($client);
    }

    public function testGetBaseUri(): void
    {
        $expected = '/networking/ipv6/pools';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields(): void
    {
        $expected = [
            'range',
            'region',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity(): void
    {
        self::assertInstanceOf(IPv6Pool::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): IPv6PoolRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new IPv6PoolRepository($linodeClient);
    }
}
