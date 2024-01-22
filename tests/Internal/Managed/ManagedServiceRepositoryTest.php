<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal\Managed;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Linode\Entity\Managed\ManagedService;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Managed\ManagedServiceRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\Managed\ManagedServiceRepository
 */
final class ManagedServiceRepositoryTest extends TestCase
{
    use ReflectionTrait;

    protected ManagedServiceRepositoryInterface $repository;

    protected function setUp(): void
    {
        $client = new LinodeClient();

        $this->repository = new ManagedServiceRepository($client);
    }

    public function testCreate(): void
    {
        $request = [
            'json' => [
                'service_type'       => 'URL',
                'label'              => 'prod-1',
                'address'            => 'https://example.org',
                'timeout'            => 30,
                'body'               => 'it worked',
                'consultation_group' => 'on-call',
                'notes'              => 'The service name is my-cool-application',
                'region'             => null,
                'credentials'        => [
                    9991,
                ],
            ],
        ];

        $response = <<<'JSON'
                        {
                            "id": 9944,
                            "status": "ok",
                            "service_type": "URL",
                            "label": "prod-1",
                            "address": "https://example.org",
                            "timeout": 30,
                            "body": "it worked",
                            "consultation_group": "on-call",
                            "notes": "The service name is my-cool-application",
                            "region": null,
                            "credentials": [
                                9991
                            ],
                            "created": "2018-01-01T00:01:01",
                            "updated": "2018-03-01T00:01:01"
                        }
            JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/managed/services', $request, new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $entity = $repository->create([
            ManagedService::FIELD_SERVICE_TYPE       => 'URL',
            ManagedService::FIELD_LABEL              => 'prod-1',
            ManagedService::FIELD_ADDRESS            => 'https://example.org',
            ManagedService::FIELD_TIMEOUT            => 30,
            ManagedService::FIELD_BODY               => 'it worked',
            ManagedService::FIELD_CONSULTATION_GROUP => 'on-call',
            ManagedService::FIELD_NOTES              => 'The service name is my-cool-application',
            ManagedService::FIELD_REGION             => null,
            ManagedService::FIELD_CREDENTIALS        => [
                9991,
            ],
        ]);

        self::assertInstanceOf(ManagedService::class, $entity);
        self::assertSame(9944, $entity->id);
        self::assertSame('prod-1', $entity->label);
    }

    public function testUpdate(): void
    {
        $request = [
            'json' => [
                'service_type'       => 'URL',
                'label'              => 'prod-1',
                'address'            => 'https://example.org',
                'timeout'            => 30,
                'body'               => 'it worked',
                'consultation_group' => 'on-call',
                'notes'              => 'The service name is my-cool-application',
                'region'             => null,
                'credentials'        => [
                    9991,
                ],
            ],
        ];

        $response = <<<'JSON'
                        {
                            "id": 9944,
                            "status": "ok",
                            "service_type": "URL",
                            "label": "prod-1",
                            "address": "https://example.org",
                            "timeout": 30,
                            "body": "it worked",
                            "consultation_group": "on-call",
                            "notes": "The service name is my-cool-application",
                            "region": null,
                            "credentials": [
                                9991
                            ],
                            "created": "2018-01-01T00:01:01",
                            "updated": "2018-03-01T00:01:01"
                        }
            JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['PUT', 'https://api.linode.com/v4/managed/services/9944', $request, new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $entity = $repository->update(9944, [
            ManagedService::FIELD_SERVICE_TYPE       => 'URL',
            ManagedService::FIELD_LABEL              => 'prod-1',
            ManagedService::FIELD_ADDRESS            => 'https://example.org',
            ManagedService::FIELD_TIMEOUT            => 30,
            ManagedService::FIELD_BODY               => 'it worked',
            ManagedService::FIELD_CONSULTATION_GROUP => 'on-call',
            ManagedService::FIELD_NOTES              => 'The service name is my-cool-application',
            ManagedService::FIELD_REGION             => null,
            ManagedService::FIELD_CREDENTIALS        => [
                9991,
            ],
        ]);

        self::assertInstanceOf(ManagedService::class, $entity);
        self::assertSame(9944, $entity->id);
        self::assertSame('prod-1', $entity->label);
    }

    public function testDelete(): void
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['DELETE', 'https://api.linode.com/v4/managed/services/9944', [], new Response(200, [], null)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $repository->delete(9944);

        self::assertTrue(true);
    }

    public function testDisable(): void
    {
        $response = <<<'JSON'
                        {
                            "id": 9944,
                            "status": "ok",
                            "service_type": "URL",
                            "label": "prod-1",
                            "address": "https://example.org",
                            "timeout": 30,
                            "body": "it worked",
                            "consultation_group": "on-call",
                            "notes": "The service name is my-cool-application",
                            "region": null,
                            "credentials": [
                                9991
                            ],
                            "created": "2018-01-01T00:01:01",
                            "updated": "2018-03-01T00:01:01"
                        }
            JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/managed/services/9944/disable', [], new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $entity = $repository->disable(9944);

        self::assertInstanceOf(ManagedService::class, $entity);
        self::assertSame(9944, $entity->id);
        self::assertSame('prod-1', $entity->label);
    }

    public function testEnable(): void
    {
        $response = <<<'JSON'
                        {
                            "id": 9944,
                            "status": "ok",
                            "service_type": "URL",
                            "label": "prod-1",
                            "address": "https://example.org",
                            "timeout": 30,
                            "body": "it worked",
                            "consultation_group": "on-call",
                            "notes": "The service name is my-cool-application",
                            "region": null,
                            "credentials": [
                                9991
                            ],
                            "created": "2018-01-01T00:01:01",
                            "updated": "2018-03-01T00:01:01"
                        }
            JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/managed/services/9944/enable', [], new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $entity = $repository->enable(9944);

        self::assertInstanceOf(ManagedService::class, $entity);
        self::assertSame(9944, $entity->id);
        self::assertSame('prod-1', $entity->label);
    }

    public function testGetSshKey(): void
    {
        $response = <<<'JSON'
                        {
                            "ssh_key": "ssh-rsa AAAAB...oD2ZQ== managedservices@linode"
                        }
            JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['GET', 'https://api.linode.com/v4/managed/credentials/sshkey', [], new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $result = $repository->getSshKey();

        self::assertSame('ssh-rsa AAAAB...oD2ZQ== managedservices@linode', $result);
    }

    public function testGetBaseUri(): void
    {
        $expected = '/managed/services';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields(): void
    {
        $expected = [
            'id',
            'status',
            'service_type',
            'label',
            'address',
            'consultation_group',
            'timeout',
            'body',
            'notes',
            'region',
            'credentials',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity(): void
    {
        self::assertInstanceOf(ManagedService::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): ManagedServiceRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new ManagedServiceRepository($linodeClient);
    }
}
