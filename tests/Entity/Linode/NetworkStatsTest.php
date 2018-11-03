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

use Linode\Entity\TimeValue;
use Linode\LinodeClient;
use PHPUnit\Framework\TestCase;

class NetworkStatsTest extends TestCase
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
            'private_in'  => [
                [1521484400000, 195.18],
            ],
            'private_out' => [
                [1521484800000, 5.6],
            ],
        ];

        $entity = new NetworkStats($this->client, $data);

        self::assertCount(1, $entity->in);
        self::assertInstanceOf(TimeValue::class, $entity->in[0]);
        self::assertSame(1521483600000, $entity->in[0]->time);
        self::assertSame(2004.36, $entity->in[0]->value);

        self::assertCount(1, $entity->out);
        self::assertInstanceOf(TimeValue::class, $entity->out[0]);
        self::assertSame(1521484000000, $entity->out[0]->time);
        self::assertSame(3928.91, $entity->out[0]->value);

        self::assertCount(1, $entity->private_in);
        self::assertInstanceOf(TimeValue::class, $entity->private_in[0]);
        self::assertSame(1521484400000, $entity->private_in[0]->time);
        self::assertSame(195.18, $entity->private_in[0]->value);

        self::assertCount(1, $entity->private_out);
        self::assertInstanceOf(TimeValue::class, $entity->private_out[0]);
        self::assertSame(1521484800000, $entity->private_out[0]->time);
        self::assertSame(5.6, $entity->private_out[0]->value);

        /** @noinspection PhpUndefinedFieldInspection */
        self::assertNull($entity->unknown);
    }
}
