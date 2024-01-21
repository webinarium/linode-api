<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal\Domains;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Linode\Entity\Domains\Domain;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Domains\DomainRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\Domains\DomainRepository
 */
final class DomainRepositoryTest extends TestCase
{
    use ReflectionTrait;

    protected DomainRepositoryInterface $repository;

    protected function setUp(): void
    {
        $client = new LinodeClient();

        $this->repository = new DomainRepository($client);
    }

    public function testCreate(): void
    {
        $request = [
            'json' => [
                'domain'    => 'example.org',
                'type'      => 'master',
                'soa_email' => 'admin@example.org',
            ],
        ];

        $response = <<<'JSON'
                        {
                            "id": 123,
                            "type": "master",
                            "domain": "example.org",
                            "group": null,
                            "status": "active",
                            "description": null,
                            "soa_email": "admin@example.org",
                            "retry_sec": 300,
                            "master_ips": [ ],
                            "axfr_ips": [ ],
                            "expire_sec": 300,
                            "refresh_sec": 300,
                            "ttl_sec": 300
                        }
            JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/domains', $request, new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $entity = $repository->create([
            Domain::FIELD_DOMAIN    => 'example.org',
            Domain::FIELD_TYPE      => Domain::TYPE_MASTER,
            Domain::FIELD_SOA_EMAIL => 'admin@example.org',
        ]);

        self::assertInstanceOf(Domain::class, $entity);
        self::assertSame(123, $entity->id);
        self::assertSame('example.org', $entity->domain);
        self::assertSame('master', $entity->type);
    }

    public function testUpdate(): void
    {
        $request = [
            'json' => [
                'domain'    => 'example.org',
                'type'      => 'master',
                'soa_email' => 'admin@example.org',
            ],
        ];

        $response = <<<'JSON'
                        {
                            "id": 123,
                            "type": "master",
                            "domain": "example.org",
                            "group": null,
                            "status": "active",
                            "description": null,
                            "soa_email": "admin@example.org",
                            "retry_sec": 300,
                            "master_ips": [],
                            "axfr_ips": [],
                            "expire_sec": 300,
                            "refresh_sec": 300,
                            "ttl_sec": 300
                        }
            JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['PUT', 'https://api.linode.com/v4/domains/123', $request, new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $entity = $repository->update(123, [
            Domain::FIELD_DOMAIN    => 'example.org',
            Domain::FIELD_TYPE      => Domain::TYPE_MASTER,
            Domain::FIELD_SOA_EMAIL => 'admin@example.org',
        ]);

        self::assertInstanceOf(Domain::class, $entity);
        self::assertSame(123, $entity->id);
        self::assertSame('example.org', $entity->domain);
        self::assertSame('master', $entity->type);
    }

    public function testDelete(): void
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['DELETE', 'https://api.linode.com/v4/domains/123', [], new Response(200, [], null)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $repository->delete(123);

        self::assertTrue(true);
    }

    public function testImport(): void
    {
        $request = [
            'json' => [
                'domain'            => 'example.com',
                'remote_nameserver' => 'examplenameserver.com',
            ],
        ];

        $response = <<<'JSON'
                        {
                            "id": 123,
                            "type": "master",
                            "domain": "example.org",
                            "group": null,
                            "status": "active",
                            "description": null,
                            "soa_email": "admin@example.org",
                            "retry_sec": 300,
                            "master_ips": [],
                            "axfr_ips": [],
                            "expire_sec": 300,
                            "refresh_sec": 300,
                            "ttl_sec": 300
                        }
            JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/domains/import', $request, new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $entity = $repository->import('example.com', 'examplenameserver.com');

        self::assertInstanceOf(Domain::class, $entity);
        self::assertSame(123, $entity->id);
        self::assertSame('example.org', $entity->domain);
        self::assertSame('master', $entity->type);
    }

    public function testClone(): void
    {
        $request = [
            'json' => [
                'domain' => 'example.com',
            ],
        ];

        $response = <<<'JSON'
                        {
                            "id": 1234,
                            "type": "master",
                            "domain": "example.org",
                            "group": null,
                            "status": "active",
                            "description": null,
                            "soa_email": "admin@example.org",
                            "retry_sec": 300,
                            "master_ips": [],
                            "axfr_ips": [],
                            "expire_sec": 300,
                            "refresh_sec": 300,
                            "ttl_sec": 300
                        }
            JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/domains/clone', $request, new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $entity = $repository->clone(123, 'example.com');

        self::assertInstanceOf(Domain::class, $entity);
        self::assertSame(1234, $entity->id);
        self::assertSame('example.org', $entity->domain);
        self::assertSame('master', $entity->type);
    }

    public function testGetBaseUri(): void
    {
        $expected = '/domains';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields(): void
    {
        $expected = [
            'id',
            'domain',
            'type',
            'status',
            'soa_email',
            'group',
            'description',
            'ttl_sec',
            'refresh_sec',
            'retry_sec',
            'expire_sec',
            'master_ips',
            'axfr_ips',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity(): void
    {
        self::assertInstanceOf(Domain::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): DomainRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new DomainRepository($linodeClient);
    }
}
