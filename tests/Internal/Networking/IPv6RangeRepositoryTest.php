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

class IPv6RangeRepositoryTest extends TestCase
{
    use ReflectionTrait;

    /** @var IPv6RangeRepository */
    protected $repository;

    protected function setUp()
    {
        $client = new LinodeClient();

        $this->repository = new IPv6RangeRepository($client);
    }

    public function testGetBaseUri()
    {
        $expected = '/networking/ipv6/ranges';

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
        self::assertInstanceOf(IPv6Range::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): IPv6RangeRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new IPv6RangeRepository($linodeClient);
    }
}
