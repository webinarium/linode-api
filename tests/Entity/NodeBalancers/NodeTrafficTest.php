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

use Linode\Entity\TimeValue;
use Linode\LinodeClient;
use PHPUnit\Framework\TestCase;

class NodeTrafficTest extends TestCase
{
    protected $client;

    protected function setUp()
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties()
    {
        $data = [
            'in'          => [
                [1521483600000, 2004.36],
            ],
            'out'         => [
                [1521484000000, 3928.91],
            ],
        ];

        $entity = new NodeTraffic($this->client, $data);

        self::assertCount(1, $entity->in);
        self::assertInstanceOf(TimeValue::class, $entity->in[0]);
        self::assertSame(1521483600000, $entity->in[0]->time);
        self::assertSame(2004.36, $entity->in[0]->value);

        self::assertCount(1, $entity->out);
        self::assertInstanceOf(TimeValue::class, $entity->out[0]);
        self::assertSame(1521484000000, $entity->out[0]->time);
        self::assertSame(3928.91, $entity->out[0]->value);

        /** @noinspection PhpUndefinedFieldInspection */
        self::assertNull($entity->unknown);
    }
}
