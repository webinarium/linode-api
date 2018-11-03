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

class TimeValueTest extends TestCase
{
    public function testIsSet()
    {
        $entity = new TimeValue(1521483600000, 0.42);

        self::assertTrue(isset($entity->time));
        self::assertTrue(isset($entity->value));
        self::assertFalse(isset($entity->unknown));
    }

    public function testGet()
    {
        $entity = new TimeValue(1521483600000, 0.42);

        self::assertSame(1521483600000, $entity->time);
        self::assertSame(0.42, $entity->value);
        self::assertNull($entity->unknown);
    }
}
