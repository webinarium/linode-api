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
use Linode\Entity\Networking\IPv6Pool;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Networking\IPv6PoolRepositoryInterface;
use PHPUnit\Framework\TestCase;

class IPv6PoolRepositoryTest extends TestCase
{
    use ReflectionTrait;

    /** @var IPv6PoolRepository */
    protected $repository;

    protected function setUp()
    {
        $client = new LinodeClient();

        $this->repository = new IPv6PoolRepository($client);
    }

    public function testGetBaseUri()
    {
        $expected = '/networking/ipv6/pools';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields()
    {
        $expected = [
            'range',
            'region',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity()
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
