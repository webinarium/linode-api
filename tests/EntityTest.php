<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Entity
 */
final class EntityTest extends TestCase
{
    protected LinodeClient $client;

    protected function setUp(): void
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    /**
     * @covers ::__construct
     * @covers ::__isset
     */
    public function testIsSet(): void
    {
        $data = [
            'id'          => 'g6-standard-1',
            'label'       => 'Linode 2GB',
            'class'       => 'standard',
            'memory'      => 2048,
            'vcpus'       => 1,
            'price'       => [
                'hourly'  => 0.015,
                'monthly' => 10,
            ],
        ];

        $entity = new class($this->client, $data) extends Entity {};

        self::assertTrue(isset($entity->class));
        self::assertFalse(isset($entity->disk));
    }

    /**
     * @covers ::__construct
     * @covers ::__get
     */
    public function testGet(): void
    {
        $data = [
            'id'          => 'g6-standard-1',
            'label'       => 'Linode 2GB',
            'class'       => 'standard',
            'memory'      => 2048,
            'vcpus'       => 1,
            'price'       => [
                'hourly'  => 0.015,
                'monthly' => 10,
            ],
        ];

        $entity = new class($this->client, $data) extends Entity {};

        self::assertSame('standard', $entity->class);
        self::assertSame(2048, $entity->memory);
        self::assertNull($entity->disk);
        self::assertIsArray($entity->price);
    }

    /**
     * @covers ::__construct
     * @covers ::toArray
     */
    public function testToArray(): void
    {
        $data = [
            'id'          => 'g6-standard-1',
            'label'       => 'Linode 2GB',
            'class'       => 'standard',
            'memory'      => 2048,
            'vcpus'       => 1,
            'price'       => [
                'hourly'  => 0.015,
                'monthly' => 10,
            ],
        ];

        $entity = new class($this->client, $data) extends Entity {};

        self::assertSame($data, $entity->toArray());
    }
}
