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
use Linode\Entity\Linode\Disk;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Linode\DiskRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\Linode\DiskRepository
 */
final class DiskRepositoryTest extends TestCase
{
    use ReflectionTrait;

    protected DiskRepositoryInterface $repository;

    protected function setUp(): void
    {
        $client = new LinodeClient();

        $this->repository = new DiskRepository($client, 123);
    }

    public function testCreate(): void
    {
        $request = [
            'json' => [
                'size'             => 48640,
                'label'            => 'Debian 9 Disk',
                'filesystem'       => 'ext4',
                'read_only'        => false,
                'image'            => 'linode/debian9',
                'authorized_keys'  => [
                    'ssh-rsa AAAA_valid_public_ssh_key_123456785== user@their-computer',
                ],
                'authorized_users' => [
                    'myUser',
                    'secondaryUser',
                ],
                'root_pass'        => 'aComplexP@ssword',
                'stackscript_id'   => 10079,
                'stackscript_data' => [
                    'gh_username' => 'linode',
                ],
            ],
        ];

        $response = <<<'JSON'
                        {
                            "id": 25674,
                            "label": "Debian 9 Disk",
                            "status": "ready",
                            "size": 48640,
                            "filesystem": "ext4",
                            "created": "2018-01-01T00:01:01",
                            "updated": "2018-01-01T00:01:01"
                        }
            JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/linode/instances/123/disks', $request, new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $entity = $repository->create([
            Disk::FIELD_SIZE             => 48640,
            Disk::FIELD_LABEL            => 'Debian 9 Disk',
            Disk::FIELD_FILESYSTEM       => 'ext4',
            Disk::FIELD_READ_ONLY        => false,
            Disk::FIELD_IMAGE            => 'linode/debian9',
            Disk::FIELD_AUTHORIZED_KEYS  => [
                'ssh-rsa AAAA_valid_public_ssh_key_123456785== user@their-computer',
            ],
            Disk::FIELD_AUTHORIZED_USERS => [
                'myUser',
                'secondaryUser',
            ],
            Disk::FIELD_ROOT_PASS        => 'aComplexP@ssword',
            Disk::FIELD_STACKSCRIPT_ID   => 10079,
            Disk::FIELD_STACKSCRIPT_DATA => [
                'gh_username' => 'linode',
            ],
        ]);

        self::assertInstanceOf(Disk::class, $entity);
        self::assertSame(25674, $entity->id);
        self::assertSame('Debian 9 Disk', $entity->label);
    }

    public function testUpdate(): void
    {
        $request = [
            'json' => [
                'label'      => 'Debian 9 Disk',
                'filesystem' => 'ext4',
            ],
        ];

        $response = <<<'JSON'
                        {
                            "id": 25674,
                            "label": "Debian 9 Disk",
                            "status": "ready",
                            "size": 48640,
                            "filesystem": "ext4",
                            "created": "2018-01-01T00:01:01",
                            "updated": "2018-01-01T00:01:01"
                        }
            JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['PUT', 'https://api.linode.com/v4/linode/instances/123/disks/25674', $request, new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $entity = $repository->update(25674, [
            Disk::FIELD_LABEL      => 'Debian 9 Disk',
            Disk::FIELD_FILESYSTEM => Disk::FILESYSTEM_EXT4,
        ]);

        self::assertInstanceOf(Disk::class, $entity);
        self::assertSame(25674, $entity->id);
        self::assertSame('Debian 9 Disk', $entity->label);
    }

    public function testDelete(): void
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['DELETE', 'https://api.linode.com/v4/linode/instances/123/disks/25674', [], new Response(200, [], null)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $repository->delete(25674);

        self::assertTrue(true);
    }

    public function testResize(): void
    {
        $request = [
            'json' => [
                'size' => 2048,
            ],
        ];

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/linode/instances/123/disks/25674/resize', $request, new Response(200, [], null)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $repository->resize(25674, 2048);

        self::assertTrue(true);
    }

    public function testResetPassword(): void
    {
        $request = [
            'json' => [
                'password' => 'another@complex^Password123',
            ],
        ];

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/linode/instances/123/disks/25674/password', $request, new Response(200, [], null)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $repository->resetPassword(25674, 'another@complex^Password123');

        self::assertTrue(true);
    }

    public function testGetBaseUri(): void
    {
        $expected = '/linode/instances/123/disks';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields(): void
    {
        $expected = [
            'id',
            'label',
            'status',
            'size',
            'filesystem',
            'created',
            'updated',
            'read_only',
            'image',
            'root_pass',
            'authorized_keys',
            'authorized_users',
            'stackscript_id',
            'stackscript_data',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity(): void
    {
        self::assertInstanceOf(Disk::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): DiskRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new DiskRepository($linodeClient, 123);
    }
}
