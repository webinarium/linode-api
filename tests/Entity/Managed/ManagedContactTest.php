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
 * @coversDefaultClass \Linode\Entity\Managed\ManagedContact
 */
final class ManagedContactTest extends TestCase
{
    protected LinodeClient $client;

    protected function setUp(): void
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties(): void
    {
        $data = [
            'id'      => 567,
            'name'    => 'John Doe',
            'email'   => 'john.doe@example.org',
            'phone'   => [
                'primary'   => '123-456-7890',
                'secondary' => null,
            ],
            'group'   => 'on-call',
            'updated' => '2018-01-01T00:01:01',
        ];

        $entity = new ManagedContact($this->client, $data);

        self::assertInstanceOf(Phone::class, $entity->phone);
        self::assertSame('John Doe', $entity->name);
    }
}
