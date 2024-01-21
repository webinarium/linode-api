<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity\Managed;

use Linode\LinodeClient;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Entity\Managed\ManagedIssue
 */
final class ManagedIssueTest extends TestCase
{
    protected LinodeClient $client;

    protected function setUp(): void
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties(): void
    {
        $data = [
            'id'       => 823,
            'created'  => '2018-01-01T00:01:01',
            'services' => [
                654,
            ],
            'entity'   => [
                'id'    => 98765,
                'type'  => 'ticket',
                'label' => 'Managed Issue opened!',
                'url'   => '/support/tickets/98765',
            ],
        ];

        $entity = new ManagedIssue($this->client, $data);

        self::assertInstanceOf(ManagedIssueEntity::class, $entity->entity);
        self::assertSame(823, $entity->id);
    }
}
