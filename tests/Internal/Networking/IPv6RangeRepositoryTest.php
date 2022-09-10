<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal\Networking;

use GuzzleHttp\Client;
use Linode\Entity\Networking\IPv6Range;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Networking\IPv6RangeRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\Networking\IPv6RangeRepository
 */
final class IPv6RangeRepositoryTest extends TestCase
{
    use ReflectionTrait;

    protected IPv6RangeRepositoryInterface $repository;

    protected function setUp(): void
    {
        $client = new LinodeClient();

        $this->repository = new IPv6RangeRepository($client);
    }

    public function testGetBaseUri(): void
    {
        $expected = '/networking/ipv6/ranges';

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
        self::assertInstanceOf(IPv6Range::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): IPv6RangeRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new IPv6RangeRepository($linodeClient);
    }
}
