<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity\Account;

use Linode\Entity\LinodeEntity;
use Linode\LinodeClient;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Entity\Account\Event
 */
final class EventTest extends TestCase
{
    protected LinodeClient $client;

    protected function setUp(): void
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties(): void
    {
        $data = [
            'id'               => 123,
            'action'           => 'ticket_create',
            'created'          => '2018-01-01T00=>01=>01',
            'entity'           => [
                'id'    => 11111,
                'label' => 'Problem booting my Linode',
                'type'  => 'ticket',
                'url'   => '/v4/support/tickets/11111',
            ],
            'percent_complete' => null,
            'rate'             => null,
            'read'             => true,
            'seen'             => true,
            'status'           => 'failed',
            'time_remaining'   => null,
            'username'         => 'exampleUser',
        ];

        $entity = new Event($this->client, $data);

        self::assertInstanceOf(LinodeEntity::class, $entity->entity);
        self::assertSame(123, $entity->id);
    }
}
