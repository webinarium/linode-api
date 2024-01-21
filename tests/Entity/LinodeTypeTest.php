<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity;

use Linode\LinodeClient;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Entity\LinodeType
 */
final class LinodeTypeTest extends TestCase
{
    protected LinodeClient $client;

    protected function setUp(): void
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testPrice(): void
    {
        $data = [
            'id'          => 'g6-standard-2',
            'label'       => 'Linode 4GB',
            'disk'        => 81920,
            'class'       => 'standard',
            'price'       => [
                'hourly'  => 0.03,
                'monthly' => 20,
            ],
            'addons'      => [
                'backups' => [
                    'price' => [
                        'hourly'  => 0.008,
                        'monthly' => 5,
                    ],
                ],
            ],
            'network_out' => 1000,
            'memory'      => 4096,
            'successor'   => null,
            'transfer'    => 4000,
            'vcpus'       => 2,
        ];

        $entity = new LinodeType($this->client, $data);

        self::assertSame('standard', $entity->class);

        $price = $entity->price;

        self::assertInstanceOf(Price::class, $price);
        self::assertSame(0.03, $price->hourly);
        self::assertSame(20, $price->monthly);
    }
}
