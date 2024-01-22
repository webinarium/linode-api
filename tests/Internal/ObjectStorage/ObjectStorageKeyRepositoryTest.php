<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal\ObjectStorage;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Linode\Entity\ObjectStorage\ObjectStorageKey;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\ObjectStorage\ObjectStorageKeyRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\ObjectStorage\ObjectStorageKeyRepository
 */
final class ObjectStorageKeyRepositoryTest extends TestCase
{
    use ReflectionTrait;

    protected ObjectStorageKeyRepositoryInterface $repository;

    protected function setUp(): void
    {
        $client = new LinodeClient();

        $this->repository = new ObjectStorageKeyRepository($client);
    }

    public function testCreate(): void
    {
        $request = [
            'json' => [
                'label' => 'my-object-storage-key',
            ],
        ];

        $response = <<<'JSON'
                        {
                            "access_key": "KVAKUTGBA4WTR2NSJQ81",
                            "id": 123,
                            "label": "my-object-storage-key",
                            "secret_key": "OiA6F5r0niLs3QA2stbyq7mY5VCV7KqOzcmitmHw"
                        }
            JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4beta/object-storage/keys', $request, new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $entity = $repository->create([
            ObjectStorageKey::FIELD_LABEL => 'my-object-storage-key',
        ]);

        self::assertInstanceOf(ObjectStorageKey::class, $entity);
        self::assertSame(123, $entity->id);
        self::assertSame('my-object-storage-key', $entity->label);
        self::assertSame('KVAKUTGBA4WTR2NSJQ81', $entity->access_key);
        self::assertSame('OiA6F5r0niLs3QA2stbyq7mY5VCV7KqOzcmitmHw', $entity->secret_key);
    }

    public function testUpdate(): void
    {
        $request = [
            'json' => [
                'label' => 'my-key',
            ],
        ];

        $response = <<<'JSON'
                        {
                            "access_key": "KVAKUTGBA4WTR2NSJQ81",
                            "id": 123,
                            "label": "my-key",
                            "secret_key": "OiA6F5r0niLs3QA2stbyq7mY5VCV7KqOzcmitmHw"
                        }
            JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['PUT', 'https://api.linode.com/v4beta/object-storage/keys/789', $request, new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $entity = $repository->update(789, [
            ObjectStorageKey::FIELD_LABEL => 'my-key',
        ]);

        self::assertInstanceOf(ObjectStorageKey::class, $entity);
        self::assertSame(123, $entity->id);
        self::assertSame('my-key', $entity->label);
        self::assertSame('KVAKUTGBA4WTR2NSJQ81', $entity->access_key);
        self::assertSame('OiA6F5r0niLs3QA2stbyq7mY5VCV7KqOzcmitmHw', $entity->secret_key);
    }

    public function testRevoke(): void
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['DELETE', 'https://api.linode.com/v4beta/object-storage/keys/123', [], new Response(200, [], null)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $repository->revoke(123);

        self::assertTrue(true);
    }

    public function testGetBaseUri(): void
    {
        $expected = 'beta/object-storage/keys';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields(): void
    {
        $expected = [
            'id',
            'label',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity(): void
    {
        self::assertInstanceOf(ObjectStorageKey::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): ObjectStorageKeyRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new ObjectStorageKeyRepository($linodeClient);
    }
}
