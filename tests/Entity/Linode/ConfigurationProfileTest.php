<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity\Linode;

use Linode\LinodeClient;
use PHPUnit\Framework\TestCase;

class ConfigurationProfileTest extends TestCase
{
    protected $client;

    protected function setUp()
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties()
    {
        $entity = new ConfigurationProfile($this->client, [
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
        ]);

        self::assertInstanceOf(Helpers::class, $entity->helpers);
        self::assertTrue($entity->helpers->updatedb_disabled);
        self::assertTrue($entity->helpers->distro);
        self::assertTrue($entity->helpers->modules_dep);
        self::assertTrue($entity->helpers->network);
        self::assertFalse($entity->helpers->devtmpfs_automount);

        self::assertInstanceOf(Devices::class, $entity->devices);
        self::assertInstanceOf(Device::class, $entity->devices->sda);
        self::assertSame(124458, $entity->devices->sda->disk_id);
        self::assertNull($entity->devices->sda->volume_id);

        self::assertSame('linode/latest-64bit', $entity->kernel);
    }
}
