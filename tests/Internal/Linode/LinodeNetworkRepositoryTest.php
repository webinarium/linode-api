<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal\Linode;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Linode\Entity\Linode\IPv4Information;
use Linode\Entity\Linode\IPv6Information;
use Linode\Entity\Linode\NetworkInformation;
use Linode\Entity\Networking\IPAddress;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Linode\LinodeNetworkRepositoryInterface;
use PHPUnit\Framework\TestCase;

class LinodeNetworkRepositoryTest extends TestCase
{
    use ReflectionTrait;

    /** @var LinodeNetworkRepository */
    protected $repository;

    protected function setUp()
    {
        $client = new LinodeClient();

        $this->repository = new LinodeNetworkRepository($client, 123);
    }

    public function testGetNetworkInformation()
    {
        $response = <<<'JSON'
            {
                "ipv4": {
                    "public": [
                        {
                            "address": "97.107.143.141",
                            "gateway": "97.107.143.1",
                            "subnet_mask": "255.255.255.0",
                            "prefix": 24,
                            "type": "ipv4",
                            "public": true,
                            "rdns": "test.example.org",
                            "linode_id": 123,
                            "region": "us-east"
                        }
                    ],
                    "private": [
                        {
                            "address": "192.168.133.234",
                            "gateway": null,
                            "subnet_mask": "255.255.128.0",
                            "prefix": 17,
                            "type": "ipv4",
                            "public": false,
                            "rdns": null,
                            "linode_id": 123,
                            "region": "us-east"
                        }
                    ],
                    "shared": [
                        {
                            "address": "97.107.143.141",
                            "gateway": "97.107.143.1",
                            "subnet_mask": "255.255.255.0",
                            "prefix": 24,
                            "type": "ipv4",
                            "public": true,
                            "rdns": "test.example.org",
                            "linode_id": 123,
                            "region": "us-east"
                        }
                    ]
                },
                "ipv6": {
                    "link_local": {
                        "address": "fe80::f03c:91ff:fe24:3a2f",
                        "gateway": "fe80::1",
                        "subnet_mask": "ffff:ffff:ffff:ffff:ffff:ffff:ffff:ffff",
                        "prefix": 64,
                        "type": "ipv6",
                        "public": false,
                        "rdns": null,
                        "linode_id": 123,
                        "region": "us-east"
                    },
                    "slaac": {
                        "address": "2600:3c03::f03c:91ff:fe24:3a2f",
                        "gateway": "fe80::1",
                        "subnet_mask": "ffff:ffff:ffff:ffff:ffff:ffff:ffff:ffff",
                        "prefix": 64,
                        "type": "ipv6",
                        "public": true,
                        "rdns": null,
                        "linode_id": 123,
                        "region": "us-east"
                    },
                    "global": {
                        "range": "2600:3c01::02:5000::",
                        "region": "us-east"
                    }
                }
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['GET', 'https://api.linode.com/v4/linode/instances/123/ips', [], new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->getNetworkInformation();

        self::assertInstanceOf(NetworkInformation::class, $entity);
        self::assertInstanceOf(IPv4Information::class, $entity->ipv4);
        self::assertCount(1, $entity->ipv4->public);
        self::assertInstanceOf(IPv6Information::class, $entity->ipv6);
        self::assertSame('2600:3c01::02:5000::', $entity->ipv6->global->range);
    }

    public function testFind()
    {
        $response = <<<'JSON'
            {
                "address": "97.107.143.141",
                "gateway": "97.107.143.1",
                "subnet_mask": "255.255.255.0",
                "prefix": 24,
                "type": "ipv4",
                "public": true,
                "rdns": "test.example.org",
                "linode_id": 123,
                "region": "us-east"
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['GET', 'https://api.linode.com/v4/linode/instances/123/ips/97.107.143.141', [], new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->find('97.107.143.141');

        self::assertInstanceOf(IPAddress::class, $entity);
        self::assertSame('97.107.143.141', $entity->address);
        self::assertSame(123, $entity->linode_id);
        self::assertTrue($entity->public);
    }

    public function testAllocate()
    {
        $request = [
            'json' => [
                'public' => true,
                'type'   => 'ipv4',
            ],
        ];

        $response = <<<'JSON'
            {
                "address": "97.107.143.141",
                "gateway": "97.107.143.1",
                "subnet_mask": "255.255.255.0",
                "prefix": 24,
                "type": "ipv4",
                "public": true,
                "rdns": "test.example.org",
                "linode_id": 123,
                "region": "us-east"
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/linode/instances/123/ips', $request, new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->allocate(true, IPAddress::TYPE_IP4);

        self::assertInstanceOf(IPAddress::class, $entity);
        self::assertSame('97.107.143.141', $entity->address);
        self::assertSame(123, $entity->linode_id);
        self::assertTrue($entity->public);
    }

    public function testUpdate()
    {
        $request = [
            'json' => [
                'rdns' => 'test.example.org',
            ],
        ];

        $response = <<<'JSON'
            {
                "address": "97.107.143.141",
                "gateway": "97.107.143.1",
                "subnet_mask": "255.255.255.0",
                "prefix": 24,
                "type": "ipv4",
                "public": true,
                "rdns": "test.example.org",
                "linode_id": 123,
                "region": "us-east"
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['PUT', 'https://api.linode.com/v4/linode/instances/123/ips/97.107.143.141', $request, new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->update('97.107.143.141', [
            IPAddress::FIELD_RDNS => 'test.example.org',
        ]);

        self::assertInstanceOf(IPAddress::class, $entity);
        self::assertSame('97.107.143.141', $entity->address);
        self::assertSame(123, $entity->linode_id);
        self::assertTrue($entity->public);
    }

    public function testDelete()
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['DELETE', 'https://api.linode.com/v4/linode/instances/123/ips/97.107.143.14', [], new Response(200, [], null)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $repository->delete('97.107.143.14');

        self::assertTrue(true);
    }

    public function testGetBaseUri()
    {
        $expected = '/linode/instances/123/ips';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    protected function mockRepository(Client $client): LinodeNetworkRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new LinodeNetworkRepository($linodeClient, 123);
    }
}
