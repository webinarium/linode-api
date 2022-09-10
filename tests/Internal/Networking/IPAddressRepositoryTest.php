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
use GuzzleHttp\Psr7\Response;
use Linode\Entity\Networking\IPAddress;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Networking\IPAddressRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\Networking\IPAddressRepository
 */
final class IPAddressRepositoryTest extends TestCase
{
    use ReflectionTrait;

    protected IPAddressRepositoryInterface $repository;

    protected function setUp(): void
    {
        $client = new LinodeClient();

        $this->repository = new IPAddressRepository($client);
    }

    public function testAllocate(): void
    {
        $request = [
            'json' => [
                'linode_id' => 123,
                'public'    => true,
                'type'      => 'ipv4',
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
                ['POST', 'https://api.linode.com/v4/networking/ips', $request, new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $entity = $repository->allocate(123, true, IPAddress::TYPE_IP4);

        self::assertInstanceOf(IPAddress::class, $entity);
        self::assertSame('97.107.143.141', $entity->address);
        self::assertSame(123, $entity->linode_id);
        self::assertTrue($entity->public);
    }

    public function testUpdate(): void
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
                ['PUT', 'https://api.linode.com/v4/networking/ips/97.107.143.141', $request, new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $entity = $repository->update('97.107.143.141', [
            IPAddress::FIELD_RDNS => 'test.example.org',
        ]);

        self::assertInstanceOf(IPAddress::class, $entity);
        self::assertSame('97.107.143.141', $entity->address);
        self::assertSame(123, $entity->linode_id);
        self::assertTrue($entity->public);
    }

    public function testAssign(): void
    {
        $request = [
            'json' => [
                'region'      => 'us-east',
                'assignments' => [
                    [
                        'address'   => '12.34.56.78',
                        'linode_id' => 123,
                    ],
                ],
            ],
        ];

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/networking/ipv4/assign', $request, new Response(200, [], null)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $repository->assign('us-east', [
            [
                IPAddress::FIELD_ADDRESS   => '12.34.56.78',
                IPAddress::FIELD_LINODE_ID => 123,
            ],
        ]);

        self::assertTrue(true);
    }

    public function testShare(): void
    {
        $request = [
            'json' => [
                'linode_id' => 123,
                'ips'       => [
                    '12.34.56.78',
                ],
            ],
        ];

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/networking/ipv4/share', $request, new Response(200, [], null)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $repository->share(123, [
            '12.34.56.78',
        ]);

        self::assertTrue(true);
    }

    public function testGetBaseUri(): void
    {
        $expected = '/networking/ips';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields(): void
    {
        $expected = [
            'address',
            'gateway',
            'subnet_mask',
            'prefix',
            'type',
            'public',
            'rdns',
            'region',
            'linode_id',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity(): void
    {
        self::assertInstanceOf(IPAddress::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): IPAddressRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new IPAddressRepository($linodeClient);
    }
}
