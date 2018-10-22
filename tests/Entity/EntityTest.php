<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

/** @noinspection PhpUndefinedFieldInspection */

namespace Linode\Entity;

use PHPUnit\Framework\TestCase;

class EntityTest extends TestCase
{
    public function testIsSet()
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

        $entity = new class($data) extends Entity {
        };

        self::assertTrue(isset($entity->class));
        self::assertFalse(isset($entity->disk));
    }

    public function testGet()
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

        $entity = new class($data) extends Entity {
        };

        self::assertSame('standard', $entity->class);
        self::assertSame(2048, $entity->memory);
        self::assertNull($entity->disk);
        self::assertInternalType('array', $entity->price);
    }

    public function testToArray()
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

        $entity = new class($data) extends Entity {
        };

        self::assertSame($data, $entity->toArray());
    }
}
