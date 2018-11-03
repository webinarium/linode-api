<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Linode\Entity\Linode;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\LinodeRepositoryInterface;
use PHPUnit\Framework\TestCase;

class LinodeRepositoryTest extends TestCase
{
    use ReflectionTrait;

    /** @var LinodeRepository */
    protected $repository;

    protected function setUp()
    {
        $client = new LinodeClient();

        $this->repository = new LinodeRepository($client);
    }

    public function testCreate()
    {
        $request = [
            'json' => [
                'backup_id'        => 1234,
                'backups_enabled'  => true,
                'swap_size'        => 512,
                'type'             => 'g6-standard-2',
                'region'           => 'us-east',
                'image'            => 'linode/debian9',
                'root_pass'        => 's3cureP@ssw0rd',
                'authorized_keys'  => [
                    'string',
                ],
                'stackscript_id'   => 10079,
                'stackscript_data' => [],
                'booted'           => true,
                'label'            => 'linode123',
                'tags'             => [
                    'example tag',
                    'another example',
                ],
                'group'            => 'Linode-Group',
                'private_ip'       => true,
                'authorized_users' => [
                    'string',
                ],
            ],
        ];

        $response = <<<'JSON'
            {
                "label": "linode123",
                "region": "us-east",
                "image": "linode/debian9",
                "type": "g6-standard-2",
                "group": "Linode-Group",
                "tags": [
                    "example tag",
                    "another example"
                ],
                "id": 123,
                "status": "running",
                "hypervisor": "kvm",
                "created": "2018-01-01T00:01:01",
                "updated": "2018-01-01T00:01:01",
                "ipv4": [
                    "123.45.67.890"
                ],
                "ipv6": "c001:d00d::1234",
                "specs": {
                    "disk": 30720,
                    "memory": 2048,
                    "vcpus": 1,
                    "transfer": 2000
                },
                "alerts": {
                    "cpu": 90,
                    "network_in": 10,
                    "network_out": 10,
                    "transfer_quota": 80,
                    "io": 10000
                },
                "backups": {
                    "enabled": true,
                    "schedule": {
                        "day": "Saturday",
                        "window": "W22"
                    }
                },
                "watchdog_enabled": true
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/linode/instances', $request, new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->create([
            Linode::FIELD_BACKUP_ID        => 1234,
            Linode::FIELD_BACKUPS_ENABLED  => true,
            Linode::FIELD_SWAP_SIZE        => 512,
            Linode::FIELD_TYPE             => 'g6-standard-2',
            Linode::FIELD_REGION           => 'us-east',
            Linode::FIELD_IMAGE            => 'linode/debian9',
            Linode::FIELD_ROOT_PASS        => 's3cureP@ssw0rd',
            Linode::FIELD_AUTHORIZED_KEYS  => [
                'string',
            ],
            Linode::FIELD_STACKSCRIPT_ID   => 10079,
            Linode::FIELD_STACKSCRIPT_DATA => [],
            Linode::FIELD_BOOTED           => true,
            Linode::FIELD_LABEL            => 'linode123',
            Linode::FIELD_TAGS             => [
                'example tag',
                'another example',
            ],
            Linode::FIELD_GROUP            => 'Linode-Group',
            Linode::FIELD_PRIVATE_IP       => true,
            Linode::FIELD_AUTHORIZED_USERS => [
                'string',
            ],
        ]);

        self::assertInstanceOf(Linode::class, $entity);
        self::assertSame(123, $entity->id);
        self::assertSame('linode123', $entity->label);
    }

    public function testUpdate()
    {
        $request = [
            'json' => [
                'label'            => 'linode123',
                'group'            => 'Linode-Group',
                'tags'             => [
                    'example tag',
                    'another example',
                ],
                'alerts'           => [
                    'cpu'            => 90,
                    'network_in'     => 10,
                    'network_out'    => 10,
                    'transfer_quota' => 80,
                    'io'             => 10000,
                ],
                'backups'          => [
                    'schedule' => [
                        'day'    => 'Saturday',
                        'window' => 'W22',
                    ],
                ],
                'watchdog_enabled' => true,
            ],
        ];

        $response = <<<'JSON'
            {
                "label": "linode123",
                "region": "us-east",
                "image": "linode/debian9",
                "type": "g6-standard-2",
                "group": "Linode-Group",
                "tags": [
                    "example tag",
                    "another example"
                ],
                "id": 123,
                "status": "running",
                "hypervisor": "kvm",
                "created": "2018-01-01T00:01:01",
                "updated": "2018-01-01T00:01:01",
                "ipv4": [
                    "123.45.67.890"
                ],
                "ipv6": "c001:d00d::1234",
                "specs": {
                    "disk": 30720,
                    "memory": 2048,
                    "vcpus": 1,
                    "transfer": 2000
                },
                "alerts": {
                    "cpu": 90,
                    "network_in": 10,
                    "network_out": 10,
                    "transfer_quota": 80,
                    "io": 10000
                },
                "backups": {
                    "enabled": true,
                    "schedule": {
                        "day": "Saturday",
                        "window": "W22"
                    }
                },
                "watchdog_enabled": true
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['PUT', 'https://api.linode.com/v4/linode/instances/123', $request, new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->update(123, [
            Linode::FIELD_LABEL            => 'linode123',
            Linode::FIELD_GROUP            => 'Linode-Group',
            Linode::FIELD_TAGS             => [
                'example tag',
                'another example',
            ],
            Linode::FIELD_ALERTS           => [
                Linode\LinodeAlerts::FIELD_CPU            => 90,
                Linode\LinodeAlerts::FIELD_NETWORK_IN     => 10,
                Linode\LinodeAlerts::FIELD_NETWORK_OUT    => 10,
                Linode\LinodeAlerts::FIELD_TRANSFER_QUOTA => 80,
                Linode\LinodeAlerts::FIELD_IO             => 10000,
            ],
            Linode::FIELD_BACKUPS          => [
                Linode\LinodeBackups::FIELD_SCHEDULE => [
                    Linode\LinodeBackupSchedule::FIELD_DAY    => 'Saturday',
                    Linode\LinodeBackupSchedule::FIELD_WINDOW => 'W22',
                ],
            ],
            Linode::FIELD_WATCHDOG_ENABLED => true,
        ]);

        self::assertInstanceOf(Linode::class, $entity);
        self::assertSame(123, $entity->id);
        self::assertSame('linode123', $entity->label);
    }

    public function testDelete()
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['DELETE', 'https://api.linode.com/v4/linode/instances/123', [], new Response(200, [], null)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $repository->delete(123);

        self::assertTrue(true);
    }

    public function testClone()
    {
        $request = [
            'json' => [
                'region'          => 'us-east',
                'type'            => 'g6-standard-2',
                'linode_id'       => 124,
                'label'           => 'cloned-linode',
                'group'           => 'Linode-Group',
                'backups_enabled' => true,
                'disks'           => [
                    25674,
                ],
                'configs'         => [
                    23456,
                ],
            ],
        ];

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/linode/instances/123/clone', $request, new Response(200, [], null)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $repository->clone(123, [
            Linode::FIELD_REGION          => 'us-east',
            Linode::FIELD_TYPE            => 'g6-standard-2',
            Linode::FIELD_LINODE_ID       => 124,
            Linode::FIELD_LABEL           => 'cloned-linode',
            Linode::FIELD_GROUP           => 'Linode-Group',
            Linode::FIELD_BACKUPS_ENABLED => true,
            Linode::FIELD_DISKS           => [
                25674,
            ],
            Linode::FIELD_CONFIGS         => [
                23456,
            ],
        ]);

        self::assertTrue(true);
    }

    public function testRebuild()
    {
        $request = [
            'json' => [
                'image'            => 'linode/debian9',
                'root_pass'        => 'aComplexP@ssword',
                'authorized_keys'  => [
                    'ssh-rsa AAAA_valid_public_ssh_key_123456785== user@their-computer',
                ],
                'authorized_users' => [
                    'myUser',
                    'secondaryUser',
                ],
                'stackscript_id'   => 10079,
                'stackscript_data' => [
                    'gh_username' => 'linode',
                ],
                'booted'           => true,
            ],
        ];

        $response = <<<'JSON'
            {
                "label": "linode123",
                "region": "us-east",
                "image": "linode/debian9",
                "type": "g6-standard-2",
                "group": "Linode-Group",
                "tags": [
                    "example tag",
                    "another example"
                ],
                "id": 123,
                "status": "running",
                "hypervisor": "kvm",
                "created": "2018-01-01T00:01:01",
                "updated": "2018-01-01T00:01:01",
                "ipv4": [
                    "123.45.67.890"
                ],
                "ipv6": "c001:d00d::1234",
                "specs": {
                    "disk": 30720,
                    "memory": 2048,
                    "vcpus": 1,
                    "transfer": 2000
                },
                "alerts": {
                    "cpu": 90,
                    "network_in": 10,
                    "network_out": 10,
                    "transfer_quota": 80,
                    "io": 10000
                },
                "backups": {
                    "enabled": true,
                    "schedule": {
                        "day": "Saturday",
                        "window": "W22"
                    }
                },
                "watchdog_enabled": true
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/linode/instances/123/rebuild', $request, new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->rebuild(123, [
            Linode::FIELD_IMAGE            => 'linode/debian9',
            Linode::FIELD_ROOT_PASS        => 'aComplexP@ssword',
            Linode::FIELD_AUTHORIZED_KEYS  => [
                'ssh-rsa AAAA_valid_public_ssh_key_123456785== user@their-computer',
            ],
            Linode::FIELD_AUTHORIZED_USERS => [
                'myUser',
                'secondaryUser',
            ],
            Linode::FIELD_STACKSCRIPT_ID   => 10079,
            Linode::FIELD_STACKSCRIPT_DATA => [
                'gh_username' => 'linode',
            ],
            Linode::FIELD_BOOTED           => true,
        ]);

        self::assertInstanceOf(Linode::class, $entity);
        self::assertSame(123, $entity->id);
        self::assertSame('linode123', $entity->label);
    }

    public function testResize()
    {
        $request = [
            'json' => [
                'type' => 'g6-standard-2',
            ],
        ];

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/linode/instances/123/resize', $request, new Response(200, [], null)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $repository->resize(123, 'g6-standard-2');

        self::assertTrue(true);
    }

    public function testMutate()
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/linode/instances/123/mutate', [], new Response(200, [], null)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $repository->mutate(123);

        self::assertTrue(true);
    }

    public function testMigrate()
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/linode/instances/123/migrate', [], new Response(200, [], null)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $repository->migrate(123);

        self::assertTrue(true);
    }

    public function testBootDefault()
    {
        $request = [
            'json' => [
                'config_id' => null,
            ],
        ];

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/linode/instances/123/boot', $request, new Response(200, [], null)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $repository->boot(123);

        self::assertTrue(true);
    }

    public function testBootWithConfig()
    {
        $request = [
            'json' => [
                'config_id' => 456,
            ],
        ];

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/linode/instances/123/boot', $request, new Response(200, [], null)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $repository->boot(123, 456);

        self::assertTrue(true);
    }

    public function testRebootDefault()
    {
        $request = [
            'json' => [
                'config_id' => null,
            ],
        ];

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/linode/instances/123/reboot', $request, new Response(200, [], null)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $repository->reboot(123);

        self::assertTrue(true);
    }

    public function testRebootWithConfig()
    {
        $request = [
            'json' => [
                'config_id' => 456,
            ],
        ];

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/linode/instances/123/reboot', $request, new Response(200, [], null)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $repository->reboot(123, 456);

        self::assertTrue(true);
    }

    public function testShutdown()
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/linode/instances/123/shutdown', [], new Response(200, [], null)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $repository->shutdown(123);

        self::assertTrue(true);
    }

    public function testRescue()
    {
        $request = [
            'json' => [
                'devices' => [
                    'sda' => [
                        'disk_id'   => 124458,
                        'volume_id' => null,
                    ],
                    'sdb' => [
                        'disk_id'   => 124458,
                        'volume_id' => null,
                    ],
                    'sdc' => [
                        'disk_id'   => 124458,
                        'volume_id' => null,
                    ],
                    'sdd' => [
                        'disk_id'   => 124458,
                        'volume_id' => null,
                    ],
                    'sde' => [
                        'disk_id'   => 124458,
                        'volume_id' => null,
                    ],
                    'sdf' => [
                        'disk_id'   => 124458,
                        'volume_id' => null,
                    ],
                    'sdg' => [
                        'disk_id'   => 124458,
                        'volume_id' => null,
                    ],
                ],
            ],
        ];

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/linode/instances/123/rescue', $request, new Response(200, [], null)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $repository->rescue(123, [
            Linode::FIELD_DEVICES => [
                Linode\Devices::FIELD_SDA => [
                    Linode\Device::FIELD_DISK_ID   => 124458,
                    Linode\Device::FIELD_VOLUME_ID => null,
                ],
                Linode\Devices::FIELD_SDB => [
                    Linode\Device::FIELD_DISK_ID   => 124458,
                    Linode\Device::FIELD_VOLUME_ID => null,
                ],
                Linode\Devices::FIELD_SDC => [
                    Linode\Device::FIELD_DISK_ID   => 124458,
                    Linode\Device::FIELD_VOLUME_ID => null,
                ],
                Linode\Devices::FIELD_SDD => [
                    Linode\Device::FIELD_DISK_ID   => 124458,
                    Linode\Device::FIELD_VOLUME_ID => null,
                ],
                Linode\Devices::FIELD_SDE => [
                    Linode\Device::FIELD_DISK_ID   => 124458,
                    Linode\Device::FIELD_VOLUME_ID => null,
                ],
                Linode\Devices::FIELD_SDF => [
                    Linode\Device::FIELD_DISK_ID   => 124458,
                    Linode\Device::FIELD_VOLUME_ID => null,
                ],
                Linode\Devices::FIELD_SDG => [
                    Linode\Device::FIELD_DISK_ID   => 124458,
                    Linode\Device::FIELD_VOLUME_ID => null,
                ],
            ],
        ]);

        self::assertTrue(true);
    }

    public function testEnableBackups()
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/linode/instances/123/backups/enable', [], new Response(200, [], null)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $repository->enableBackups(123);

        self::assertTrue(true);
    }

    public function testCancelBackups()
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/linode/instances/123/backups/cancel', [], new Response(200, [], null)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $repository->cancelBackups(123);

        self::assertTrue(true);
    }

    public function testCreateSnapshot()
    {
        $request = [
            'json' => [
                'label' => 'Webserver-Backup-2018',
            ],
        ];

        $response = <<<'JSON'
            {
                "id": 123456,
                "type": "snapshot",
                "status": "successful",
                "created": "2018-01-15T00:01:01",
                "updated": "2018-01-15T00:01:01",
                "finished": "2018-01-15T00:01:01",
                "label": "Webserver-Backup-2018",
                "configs": [
                    "My Debian 9 Config"
                ],
                "disks": [
                    {
                        "size": 9001,
                        "filesystem": "ext4",
                        "label": "My Debian 9 Disk"
                    }
                ]
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/linode/instances/123/backups', $request, new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->createSnapshot(123, 'Webserver-Backup-2018');

        self::assertInstanceOf(Linode\Backup::class, $entity);
        self::assertSame(123456, $entity->id);
        self::assertSame('Webserver-Backup-2018', $entity->label);
    }

    public function testRestoreBackup()
    {
        $request = [
            'json' => [
                'linode_id' => 789,
                'overwrite' => true,
            ],
        ];

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/linode/instances/123/backups/456/restore', $request, new Response(200, [], null)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $repository->restoreBackup(123, 456, 789);

        self::assertTrue(true);
    }

    public function testGetBackup()
    {
        $response = <<<'JSON'
            {
                "id": 456,
                "type": "snapshot",
                "status": "successful",
                "created": "2018-01-15T00:01:01",
                "updated": "2018-01-15T00:01:01",
                "finished": "2018-01-15T00:01:01",
                "label": "Webserver-Backup-2018",
                "configs": [
                    "My Debian 9 Config"
                ],
                "disks": [
                    {
                        "size": 9001,
                        "filesystem": "ext4",
                        "label": "My Debian 9 Disk"
                    }
                ]
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['GET', 'https://api.linode.com/v4/linode/instances/123/backups/456', [], new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->getBackup(123, 456);

        self::assertInstanceOf(Linode\Backup::class, $entity);
        self::assertSame(456, $entity->id);
        self::assertSame('Webserver-Backup-2018', $entity->label);
    }

    public function testGetAllBackups()
    {
        $response = <<<'JSON'
            {
                "automatic": [
                    {
                        "id": 123456,
                        "type": "automatic",
                        "status": "successful",
                        "created": "2018-01-15T00:01:01",
                        "updated": "2018-01-15T00:01:01",
                        "finished": "2018-01-15T00:01:01",
                        "label": "Webserver-Backup-2018",
                        "configs": [
                            "My Debian 9 Config"
                        ],
                        "disks": [
                            {
                                "size": 9001,
                                "filesystem": "ext4",
                                "label": "My Debian 9 Disk"
                            }
                        ]
                    }
                ],
                "snapshot": {
                    "in_progress": {
                        "id": 123456,
                        "type": "snapshot",
                        "status": "successful",
                        "created": "2018-01-15T00:01:01",
                        "updated": "2018-01-15T00:01:01",
                        "finished": "2018-01-15T00:01:01",
                        "label": "Webserver-Backup-2018",
                        "configs": [
                            "My Debian 9 Config"
                        ],
                        "disks": [
                            {
                                "size": 9001,
                                "filesystem": "ext4",
                                "label": "My Debian 9 Disk"
                            }
                        ]
                    },
                    "current": {
                        "id": 123456,
                        "type": "snapshot",
                        "status": "successful",
                        "created": "2018-01-15T00:01:01",
                        "updated": "2018-01-15T00:01:01",
                        "finished": "2018-01-15T00:01:01",
                        "label": "Webserver-Backup-2018",
                        "configs": [
                            "My Debian 9 Config"
                        ],
                        "disks": [
                            {
                                "size": 9001,
                                "filesystem": "ext4",
                                "label": "My Debian 9 Disk"
                            }
                        ]
                    }
                }
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['GET', 'https://api.linode.com/v4/linode/instances/123/backups', [], new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $data = $repository->getAllBackups(123);

        self::assertArrayHasKey('automatic', $data);
        self::assertArrayHasKey('snapshot', $data);
    }

    public function testGetCurrentStats()
    {
        $response = <<<'JSON'
            {
                "cpu": [
                    [
                        1521483600000,
                        0.42
                    ]
                ],
                "io": {
                    "io": [
                        [
                            1521484800000,
                            0.19
                        ]
                    ],
                    "swap": [
                        [
                            1521484800000,
                            0
                        ]
                    ]
                },
                "netv4": {
                    "in": [
                        [
                            1521484800000,
                            2004.36
                        ]
                    ],
                    "out": [
                        [
                            1521484800000,
                            3928.91
                        ]
                    ],
                    "private_in": [
                        [
                            1521484800000,
                            0
                        ]
                    ],
                    "private_out": [
                        [
                            1521484800000,
                            5.6
                        ]
                    ]
                },
                "netv6": {
                    "in": [
                        [
                            1521484800000,
                            0
                        ]
                    ],
                    "out": [
                        [
                            1521484800000,
                            0
                        ]
                    ],
                    "private_in": [
                        [
                            1521484800000,
                            195.18
                        ]
                    ],
                    "private_out": [
                        [
                            1521484800000,
                            5.6
                        ]
                    ]
                },
                "title": "linode.com - my-linode (linode123456) - day (5 min avg)"
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['GET', 'https://api.linode.com/v4/linode/instances/123/stats', [], new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->getCurrentStats(123);

        self::assertInstanceOf(Linode\LinodeStats::class, $entity);
        self::assertSame('linode.com - my-linode (linode123456) - day (5 min avg)', $entity->title);
        self::assertInstanceOf(Linode\IOStats::class, $entity->io);
    }

    public function testGetMonthlyStats()
    {
        $response = <<<'JSON'
            {
                "cpu": [
                    [
                        1521483600000,
                        0.42
                    ]
                ],
                "io": {
                    "io": [
                        [
                            1521484800000,
                            0.19
                        ]
                    ],
                    "swap": [
                        [
                            1521484800000,
                            0
                        ]
                    ]
                },
                "netv4": {
                    "in": [
                        [
                            1521484800000,
                            2004.36
                        ]
                    ],
                    "out": [
                        [
                            1521484800000,
                            3928.91
                        ]
                    ],
                    "private_in": [
                        [
                            1521484800000,
                            0
                        ]
                    ],
                    "private_out": [
                        [
                            1521484800000,
                            5.6
                        ]
                    ]
                },
                "netv6": {
                    "in": [
                        [
                            1521484800000,
                            0
                        ]
                    ],
                    "out": [
                        [
                            1521484800000,
                            0
                        ]
                    ],
                    "private_in": [
                        [
                            1521484800000,
                            195.18
                        ]
                    ],
                    "private_out": [
                        [
                            1521484800000,
                            5.6
                        ]
                    ]
                },
                "title": "linode.com - my-linode (linode123456) - day (5 min avg)"
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['GET', 'https://api.linode.com/v4/linode/instances/123/stats/2018/01', [], new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->getMonthlyStats(123, 2018, 1);

        self::assertInstanceOf(Linode\LinodeStats::class, $entity);
        self::assertSame('linode.com - my-linode (linode123456) - day (5 min avg)', $entity->title);
        self::assertInstanceOf(Linode\IOStats::class, $entity->io);
    }

    public function testGetBaseUri()
    {
        $expected = '/linode/instances';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields()
    {
        $expected = [
            'id',
            'label',
            'region',
            'image',
            'type',
            'status',
            'ipv4',
            'ipv6',
            'hypervisor',
            'watchdog_enabled',
            'created',
            'updated',
            'group',
            'tags',
            'specs',
            'alerts',
            'backups',
            'linode_id',
            'root_pass',
            'swap_size',
            'booted',
            'private_ip',
            'authorized_keys',
            'authorized_users',
            'backup_id',
            'backups_enabled',
            'stackscript_id',
            'stackscript_data',
            'devices',
            'disks',
            'configs',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity()
    {
        self::assertInstanceOf(Linode::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): LinodeRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new LinodeRepository($linodeClient);
    }
}
