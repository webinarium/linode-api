<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity\Account;

use Linode\Entity\LinodeEntity;
use Linode\LinodeClient;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Entity\Account\Notification
 */
final class NotificationTest extends TestCase
{
    protected LinodeClient $client;

    protected function setUp(): void
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties(): void
    {
        $data = [
            'entity'   => [
                'id'    => 3456,
                'label' => 'Linode not booting.',
                'type'  => 'ticket',
                'url'   => '/support/tickets/3456',
            ],
            'label'    => 'You have an important ticket open!',
            'message'  => 'You have an important ticket open!',
            'type'     => 'ticket_important',
            'severity' => 'major',
            'when'     => null,
            'until'    => null,
        ];

        $entity = new Notification($this->client, $data);

        self::assertInstanceOf(LinodeEntity::class, $entity->entity);
        self::assertSame('You have an important ticket open!', $entity->label);
    }
}
