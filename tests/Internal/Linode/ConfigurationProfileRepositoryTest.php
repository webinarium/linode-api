<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal\Linode;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Linode\Entity\Linode\ConfigurationProfile;
use Linode\Entity\Linode\Device;
use Linode\Entity\Linode\Devices;
use Linode\Entity\Linode\Helpers;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Linode\ConfigurationProfileRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\Linode\ConfigurationProfileRepository
 */
final class ConfigurationProfileRepositoryTest extends TestCase
{
    use ReflectionTrait;

    protected ConfigurationProfileRepositoryInterface $repository;

    protected function setUp(): void
    {
        $client = new LinodeClient();

        $this->repository = new ConfigurationProfileRepository($client, 123);
    }

    public function testCreate(): void
    {
        $request = [
            'json' => [
                'kernel'       => 'linode/latest-64bit',
                'comments'     => 'This is my main Config',
                'memory_limit' => 2048,
                'run_level'    => 'default',
                'virt_mode'    => 'paravirt',
                'helpers'      => [
                    'updatedb_disabled'  => true,
                    'distro'             => true,
                    'modules_dep'        => true,
                    'network'            => true,
                    'devtmpfs_automount' => false,
                ],
                'label'        => 'My Config',
                'devices'      => [
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
                    'sdh' => [
                        'disk_id'   => 124458,
                        'volume_id' => null,
                    ],
                ],
                'root_device'  => '/dev/sda',
            ],
        ];

        $response = <<<'JSON'
                        {
                            "id": 456,
                            "kernel": "linode/latest-64bit",
                            "comments": "This is my main Config",
                            "memory_limit": 2048,
                            "run_level": "default",
                            "virt_mode": "paravirt",
                            "helpers": {
                                "updatedb_disabled": true,
                                "distro": true,
                                "modules_dep": true,
                                "network": true,
                                "devtmpfs_automount": false
                            },
                            "label": "My Config",
                            "devices": {
                                "sda": {
                                    "disk_id": 124458,
                                    "volume_id": null
                                },
                                "sdb": {
                                    "disk_id": 124458,
                                    "volume_id": null
                                },
                                "sdc": {
                                    "disk_id": 124458,
                                    "volume_id": null
                                },
                                "sdd": {
                                    "disk_id": 124458,
                                    "volume_id": null
                                },
                                "sde": {
                                    "disk_id": 124458,
                                    "volume_id": null
                                },
                                "sdf": {
                                    "disk_id": 124458,
                                    "volume_id": null
                                },
                                "sdg": {
                                    "disk_id": 124458,
                                    "volume_id": null
                                },
                                "sdh": {
                                    "disk_id": 124458,
                                    "volume_id": null
                                }
                            },
                            "root_device": "/dev/sda"
                        }
            JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/linode/instances/123/configs', $request, new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $entity = $repository->create([
            ConfigurationProfile::FIELD_KERNEL       => 'linode/latest-64bit',
            ConfigurationProfile::FIELD_COMMENTS     => 'This is my main Config',
            ConfigurationProfile::FIELD_MEMORY_LIMIT => 2048,
            ConfigurationProfile::FIELD_RUN_LEVEL    => 'default',
            ConfigurationProfile::FIELD_VIRT_MODE    => 'paravirt',
            ConfigurationProfile::FIELD_HELPERS      => [
                Helpers::FIELD_UPDATEDB_DISABLED  => true,
                Helpers::FIELD_DISTRO             => true,
                Helpers::FIELD_MODULES_DEP        => true,
                Helpers::FIELD_NETWORK            => true,
                Helpers::FIELD_DEVTMPFS_AUTOMOUNT => false,
            ],
            ConfigurationProfile::FIELD_LABEL        => 'My Config',
            ConfigurationProfile::FIELD_DEVICES      => [
                Devices::FIELD_SDA => [
                    Device::FIELD_DISK_ID   => 124458,
                    Device::FIELD_VOLUME_ID => null,
                ],
                Devices::FIELD_SDB => [
                    Device::FIELD_DISK_ID   => 124458,
                    Device::FIELD_VOLUME_ID => null,
                ],
                Devices::FIELD_SDC => [
                    Device::FIELD_DISK_ID   => 124458,
                    Device::FIELD_VOLUME_ID => null,
                ],
                Devices::FIELD_SDD => [
                    Device::FIELD_DISK_ID   => 124458,
                    Device::FIELD_VOLUME_ID => null,
                ],
                Devices::FIELD_SDE => [
                    Device::FIELD_DISK_ID   => 124458,
                    Device::FIELD_VOLUME_ID => null,
                ],
                Devices::FIELD_SDF => [
                    Device::FIELD_DISK_ID   => 124458,
                    Device::FIELD_VOLUME_ID => null,
                ],
                Devices::FIELD_SDG => [
                    Device::FIELD_DISK_ID   => 124458,
                    Device::FIELD_VOLUME_ID => null,
                ],
                Devices::FIELD_SDH => [
                    Device::FIELD_DISK_ID   => 124458,
                    Device::FIELD_VOLUME_ID => null,
                ],
            ],
            ConfigurationProfile::FIELD_ROOT_DEVICE  => '/dev/sda',
        ]);

        self::assertInstanceOf(ConfigurationProfile::class, $entity);
        self::assertSame(456, $entity->id);
        self::assertSame('linode/latest-64bit', $entity->kernel);
    }

    public function testUpdate(): void
    {
        $request = [
            'json' => [
                'kernel'       => 'linode/latest-64bit',
                'comments'     => 'This is my main Config',
                'memory_limit' => 2048,
                'run_level'    => 'default',
                'virt_mode'    => 'paravirt',
                'helpers'      => [
                    'updatedb_disabled'  => true,
                    'distro'             => true,
                    'modules_dep'        => true,
                    'network'            => true,
                    'devtmpfs_automount' => false,
                ],
                'label'        => 'My Config',
                'devices'      => [
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
                    'sdh' => [
                        'disk_id'   => 124458,
                        'volume_id' => null,
                    ],
                ],
                'root_device'  => '/dev/sda',
            ],
        ];

        $response = <<<'JSON'
                        {
                            "id": 456,
                            "kernel": "linode/latest-64bit",
                            "comments": "This is my main Config",
                            "memory_limit": 2048,
                            "run_level": "default",
                            "virt_mode": "paravirt",
                            "helpers": {
                                "updatedb_disabled": true,
                                "distro": true,
                                "modules_dep": true,
                                "network": true,
                                "devtmpfs_automount": false
                            },
                            "label": "My Config",
                            "devices": {
                                "sda": {
                                    "disk_id": 124458,
                                    "volume_id": null
                                },
                                "sdb": {
                                    "disk_id": 124458,
                                    "volume_id": null
                                },
                                "sdc": {
                                    "disk_id": 124458,
                                    "volume_id": null
                                },
                                "sdd": {
                                    "disk_id": 124458,
                                    "volume_id": null
                                },
                                "sde": {
                                    "disk_id": 124458,
                                    "volume_id": null
                                },
                                "sdf": {
                                    "disk_id": 124458,
                                    "volume_id": null
                                },
                                "sdg": {
                                    "disk_id": 124458,
                                    "volume_id": null
                                },
                                "sdh": {
                                    "disk_id": 124458,
                                    "volume_id": null
                                }
                            },
                            "root_device": "/dev/sda"
                        }
            JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['PUT', 'https://api.linode.com/v4/linode/instances/123/configs/456', $request, new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $entity = $repository->update(456, [
            ConfigurationProfile::FIELD_KERNEL       => 'linode/latest-64bit',
            ConfigurationProfile::FIELD_COMMENTS     => 'This is my main Config',
            ConfigurationProfile::FIELD_MEMORY_LIMIT => 2048,
            ConfigurationProfile::FIELD_RUN_LEVEL    => 'default',
            ConfigurationProfile::FIELD_VIRT_MODE    => 'paravirt',
            ConfigurationProfile::FIELD_HELPERS      => [
                Helpers::FIELD_UPDATEDB_DISABLED  => true,
                Helpers::FIELD_DISTRO             => true,
                Helpers::FIELD_MODULES_DEP        => true,
                Helpers::FIELD_NETWORK            => true,
                Helpers::FIELD_DEVTMPFS_AUTOMOUNT => false,
            ],
            ConfigurationProfile::FIELD_LABEL        => 'My Config',
            ConfigurationProfile::FIELD_DEVICES      => [
                Devices::FIELD_SDA => [
                    Device::FIELD_DISK_ID   => 124458,
                    Device::FIELD_VOLUME_ID => null,
                ],
                Devices::FIELD_SDB => [
                    Device::FIELD_DISK_ID   => 124458,
                    Device::FIELD_VOLUME_ID => null,
                ],
                Devices::FIELD_SDC => [
                    Device::FIELD_DISK_ID   => 124458,
                    Device::FIELD_VOLUME_ID => null,
                ],
                Devices::FIELD_SDD => [
                    Device::FIELD_DISK_ID   => 124458,
                    Device::FIELD_VOLUME_ID => null,
                ],
                Devices::FIELD_SDE => [
                    Device::FIELD_DISK_ID   => 124458,
                    Device::FIELD_VOLUME_ID => null,
                ],
                Devices::FIELD_SDF => [
                    Device::FIELD_DISK_ID   => 124458,
                    Device::FIELD_VOLUME_ID => null,
                ],
                Devices::FIELD_SDG => [
                    Device::FIELD_DISK_ID   => 124458,
                    Device::FIELD_VOLUME_ID => null,
                ],
                Devices::FIELD_SDH => [
                    Device::FIELD_DISK_ID   => 124458,
                    Device::FIELD_VOLUME_ID => null,
                ],
            ],
            ConfigurationProfile::FIELD_ROOT_DEVICE  => '/dev/sda',
        ]);

        self::assertInstanceOf(ConfigurationProfile::class, $entity);
        self::assertSame(456, $entity->id);
        self::assertSame('linode/latest-64bit', $entity->kernel);
    }

    public function testDelete(): void
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['DELETE', 'https://api.linode.com/v4/linode/instances/123/configs/456', [], new Response(200, [], null)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $repository->delete(456);

        self::assertTrue(true);
    }

    public function testGetBaseUri(): void
    {
        $expected = '/linode/instances/123/configs';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields(): void
    {
        $expected = [
            'id',
            'label',
            'kernel',
            'comments',
            'memory_limit',
            'run_level',
            'virt_mode',
            'helpers',
            'devices',
            'root_device',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity(): void
    {
        self::assertInstanceOf(ConfigurationProfile::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): ConfigurationProfileRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new ConfigurationProfileRepository($linodeClient, 123);
    }
}
