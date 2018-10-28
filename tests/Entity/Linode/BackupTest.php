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

class BackupTest extends TestCase
{
    protected $client;

    protected function setUp()
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties()
    {
        $data = [
            'id'       => 123456,
            'type'     => 'snapshot',
            'status'   => 'successful',
            'created'  => '2018-01-15T00=>01=>01',
            'updated'  => '2018-01-15T00=>01=>01',
            'finished' => '2018-01-15T00=>01=>01',
            'label'    => 'Webserver-Backup-2018',
            'configs'  => [
                'My Debian 9 Config',
            ],
            'disks'    => [
                [
                    'size'       => 9001,
                    'filesystem' => 'ext4',
                    'label'      => 'My Debian 9 Disk',
                ],
            ],
        ];

        $entity = new Backup($this->client, $data);

        self::assertCount(1, $entity->disks);
        self::assertInstanceOf(BackupDisk::class, $entity->disks[0]);
        self::assertSame('ext4', $entity->disks[0]->filesystem);

        self::assertSame(123456, $entity->id);
    }
}
