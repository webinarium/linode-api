<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity\Linode;

use Linode\Entity\TimeValue;
use Linode\LinodeClient;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Entity\Linode\IOStats
 */
final class IOStatsTest extends TestCase
{
    protected LinodeClient $client;

    protected function setUp(): void
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties(): void
    {
        $data = [
            'io'   => [
                [1521483600000, 0.19],
            ],
            'swap' => [
                [1521484800000, 0.42],
            ],
        ];

        $entity = new IOStats($this->client, $data);

        self::assertCount(1, $entity->io);
        self::assertInstanceOf(TimeValue::class, $entity->io[0]);
        self::assertSame(1521483600000, $entity->io[0]->time);
        self::assertSame(0.19, $entity->io[0]->value);

        self::assertCount(1, $entity->swap);
        self::assertInstanceOf(TimeValue::class, $entity->swap[0]);
        self::assertSame(1521484800000, $entity->swap[0]->time);
        self::assertSame(0.42, $entity->swap[0]->value);

        self::assertNull($entity->unknown);
    }
}
