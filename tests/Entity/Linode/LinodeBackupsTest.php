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

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Entity\Linode\LinodeBackups
 */
final class LinodeBackupsTest extends TestCase
{
    protected LinodeClient $client;

    protected function setUp(): void
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties(): void
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
