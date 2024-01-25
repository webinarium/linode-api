<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Exception;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Exception\Error
 */
final class ErrorTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testWithField(): void
    {
        $error = new Error('This field is required', 'name');

        self::assertSame('This field is required', $error->reason);
        self::assertSame('name', $error->field);
    }

    /**
     * @covers ::__construct
     */
    public function testWithoutField(): void
    {
        $error = new Error('This field is required');

        self::assertSame('This field is required', $error->reason);
        self::assertNull($error->field);
    }
}
