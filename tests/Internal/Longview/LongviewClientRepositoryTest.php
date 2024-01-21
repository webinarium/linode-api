<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal\Longview;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Linode\Entity\Longview\LongviewClient;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Longview\LongviewClientRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\Longview\LongviewClientRepository
 */
final class LongviewClientRepositoryTest extends TestCase
{
    use ReflectionTrait;

    protected LongviewClientRepositoryInterface $repository;

    protected function setUp(): void
    {
        $client = new LinodeClient();

        $this->repository = new LongviewClientRepository($client);
    }

    public function testCreate(): void
    {
        $request = [
            'json' => [
                'label' => 'client789',
            ],
        ];

        $response = <<<'JSON'
                        {
                            "id": 789,
                            "label": "client789",
                            "api_key": "BD1B4B54-D752-A76D-5A9BD8A17F39DB61",
                            "install_code": "BD1B5605-BF5E-D385-BA07AD518BE7F321",
                            "apps": {
                                "apache": true,
                                "nginx": false,
                                "mysql": true
                            },
                            "created": "2018-01-01T00:01:01.000Z",
                            "updated": "2018-01-01T00:01:01.000Z"
                        }
            JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/longview/clients', $request, new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $entity = $repository->create([
            LongviewClient::FIELD_LABEL => 'client789',
        ]);

        self::assertInstanceOf(LongviewClient::class, $entity);
        self::assertSame(789, $entity->id);
        self::assertSame('client789', $entity->label);
    }

    public function testUpdate(): void
    {
        $request = [
            'json' => [
                'label' => 'client789',
            ],
        ];

        $response = <<<'JSON'
                        {
                            "id": 789,
                            "label": "client789",
                            "api_key": "BD1B4B54-D752-A76D-5A9BD8A17F39DB61",
                            "install_code": "BD1B5605-BF5E-D385-BA07AD518BE7F321",
                            "apps": {
                                "apache": true,
                                "nginx": false,
                                "mysql": true
                            },
                            "created": "2018-01-01T00:01:01.000Z",
                            "updated": "2018-01-01T00:01:01.000Z"
                        }
            JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['PUT', 'https://api.linode.com/v4/longview/clients/789', $request, new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $entity = $repository->update(789, [
            LongviewClient::FIELD_LABEL => 'client789',
        ]);

        self::assertInstanceOf(LongviewClient::class, $entity);
        self::assertSame(789, $entity->id);
        self::assertSame('client789', $entity->label);
    }

    public function testDelete(): void
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['DELETE', 'https://api.linode.com/v4/longview/clients/789', [], new Response(200, [], null)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $repository->delete(789);

        self::assertTrue(true);
    }

    public function testGetBaseUri(): void
    {
        $expected = '/longview/clients';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields(): void
    {
        $expected = [
            'label',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity(): void
    {
        self::assertInstanceOf(LongviewClient::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): LongviewClientRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new LongviewClientRepository($linodeClient);
    }
}
