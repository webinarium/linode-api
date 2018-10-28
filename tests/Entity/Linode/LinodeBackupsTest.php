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

class LinodeBackupsTest extends TestCase
{
    protected $client;

    protected function setUp()
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties()
    {
        $data = [
            'enabled'  => true,
            'schedule' => [
                'day'    => 'Saturday',
                'window' => 'W22',
            ],
        ];

        $entity = new LinodeBackups($this->client, $data);

        self::assertInstanceOf(LinodeBackupSchedule::class, $entity->schedule);
        self::assertTrue($entity->enabled);
    }
}
