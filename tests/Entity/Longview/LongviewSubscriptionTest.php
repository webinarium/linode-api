<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity\Longview;

use Linode\Entity\Price;
use Linode\LinodeClient;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Entity\Longview\LongviewSubscription
 */
final class LongviewSubscriptionTest extends TestCase
{
    protected LinodeClient $client;

    protected function setUp(): void
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties(): void
    {
        $data = [
            'id'               => 'longview-10',
            'price'            => [
                'hourly'  => 0.06,
                'monthly' => 40,
            ],
            'label'            => 'Longivew Pro 10 pack',
            'clients_included' => 10,
        ];

        $entity = new LongviewSubscription($this->client, $data);

        self::assertInstanceOf(Price::class, $entity->price);
        self::assertSame(10, $entity->clients_included);
    }
}
