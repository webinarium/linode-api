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
 * @coversDefaultClass \Linode\Entity\Linode\LinodeStats
 */
final class LinodeStatsTest extends TestCase
{
    protected LinodeClient $client;

    protected function setUp(): void
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties(): void
    {
        $data = [
            'cpu'   => [
                [1521483600000, 0.42],
            ],
            'io'    => [
                'io'   => [
                    [1521484800000, 0.19],
                ],
                'swap' => [
                    [1521484800000, 0],
                ],
            ],
            'netv4' => [
                'in'          => [
                    [1521484800000, 2004.36],
                ],
                'out'         => [
                    [1521484800000, 3928.91],
                ],
                'private_in'  => [
                    [1521484800000, 0],
                ],
                'private_out' => [
                    [1521484800000, 5.6],
                ],
            ],
            'netv6' => [
                'in'          => [
                    [1521484800000, 0],
                ],
                'out'         => [
                    [1521484800000, 0],
                ],
                'private_in'  => [
                    [1521484800000, 195.18],
                ],
                'private_out' => [
                    [1521484800000, 5.6],
                ],
            ],
            'title' => 'linode.com - my-linode (linode123456) - day (5 min avg)',
        ];

        $entity = new LinodeStats($this->client, $data);

        self::assertCount(1, $entity->cpu);
        self::assertInstanceOf(TimeValue::class, $entity->cpu[0]);
        self::assertSame(1521483600000, $entity->cpu[0]->time);
        self::assertSame(0.42, $entity->cpu[0]->value);

        self::assertInstanceOf(IOStats::class, $entity->io);
        self::assertInstanceOf(NetworkStats::class, $entity->netv4);
        self::assertInstanceOf(NetworkStats::class, $entity->netv6);
        self::assertSame('linode.com - my-linode (linode123456) - day (5 min avg)', $entity->title);
    }
}
