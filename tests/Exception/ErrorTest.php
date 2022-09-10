<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Exception;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Exception\Error
 */
final class ErrorTest extends TestCase
{
    public function testWithField(): void
    {
        $error = new Error('This field is required', 'name');

        self::assertSame('This field is required', $error->getReason());
        self::assertSame('name', $error->getField());
    }

    public function testWithoutField(): void
    {
        $error = new Error('This field is required', null);

        self::assertSame('This field is required', $error->getReason());
        self::assertNull($error->getField());
    }
}
