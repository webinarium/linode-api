<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal\Domains;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Linode\Entity\Domains\DomainRecord;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Domains\DomainRecordRepositoryInterface;
use PHPUnit\Framework\TestCase;

class DomainRecordRepositoryTest extends TestCase
{
    use ReflectionTrait;

    /** @var DomainRecordRepository */
    protected $repository;

    protected function setUp()
    {
        $client = new LinodeClient();

        $this->repository = new DomainRecordRepository($client, 123);
    }

    public function testCreate()
    {
        $request = [
            'json' => [
                'type' => 'A',
                'name' => 'test',
            ],
        ];

        $response = <<<'JSON'
            {
                "id": 456,
                "type": "A",
                "name": "test",
                "target": "12.34.56.78",
                "priority": 50,
                "weight": 50,
                "port": 80,
                "service": null,
                "protocol": null,
                "ttl_sec": 604800,
                "tag": null
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/domains/123/records', $request, new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->create([
            DomainRecord::FIELD_TYPE => DomainRecord::TYPE_A,
            DomainRecord::FIELD_NAME => 'test',
        ]);

        self::assertInstanceOf(DomainRecord::class, $entity);
        self::assertSame(456, $entity->id);
        self::assertSame('test', $entity->name);
    }

    public function testUpdate()
    {
        $request = [
            'json' => [
                'type' => 'A',
                'name' => 'test',
            ],
        ];

        $response = <<<'JSON'
            {
                "id": 456,
                "type": "A",
                "name": "test",
                "target": "12.34.56.78",
                "priority": 50,
                "weight": 50,
                "port": 80,
                "service": null,
                "protocol": null,
                "ttl_sec": 604800,
                "tag": null
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['PUT', 'https://api.linode.com/v4/domains/123/records/456', $request, new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->update(456, [
            DomainRecord::FIELD_TYPE => DomainRecord::TYPE_A,
            DomainRecord::FIELD_NAME => 'test',
        ]);

        self::assertInstanceOf(DomainRecord::class, $entity);
        self::assertSame(456, $entity->id);
        self::assertSame('test', $entity->name);
    }

    public function testDelete()
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['DELETE', 'https://api.linode.com/v4/domains/123/records/456', [], new Response(200, [], null)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $repository->delete(456);

        self::assertTrue(true);
    }

    public function testGetBaseUri()
    {
        $expected = '/domains/123/records';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields()
    {
        $expected = [
            'id',
            'type',
            'name',
            'target',
            'ttl_sec',
            'priority',
            'weight',
            'service',
            'protocol',
            'port',
            'tag',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity()
    {
        self::assertInstanceOf(DomainRecord::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): DomainRecordRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new DomainRecordRepository($linodeClient, 123);
    }
}
