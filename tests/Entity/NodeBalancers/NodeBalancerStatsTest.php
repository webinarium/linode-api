<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity\NodeBalancers;

use Linode\LinodeClient;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Entity\NodeBalancers\NodeBalancerStats
 */
final class NodeBalancerStatsTest extends TestCase
{
    protected LinodeClient $client;

    protected function setUp(): void
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties(): void
    {
        $data = [
            'data'  => [
                'connections' => [
                    [1526391300000, 12],
                ],
                'traffic'     => [
                    'in'  => [
                        [1521483600000, 2004.36],
                    ],
                    'out' => [
                        [1521484000000, 3928.91],
                    ],
                ],
            ],
            'title' => 'linode.com - balancer12345 (12345) - day (5 min avg)',
        ];

        $entity = new NodeBalancerStats($this->client, $data);

        self::assertSame('linode.com - balancer12345 (12345) - day (5 min avg)', $entity->title);

        self::assertInstanceOf(NodeBalancerStatsData::class, $entity->data);
        self::assertInstanceOf(NodeTraffic::class, $entity->data->traffic);

        self::assertNull($entity->unknown);
    }
}
