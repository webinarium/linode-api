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
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class LinodeExceptionTest extends TestCase
{
    public function testWithErrors()
    {
        $stream = $this->createMock(StreamInterface::class);
        $stream
            ->method('getContents')
            ->willReturn('{"errors": [{"reason": "Length must be 1-128 characters", "field": "label"}, {"reason": "Domain is required", "field": "redirect_uri"}]}');

        $response = $this->createMock(ResponseInterface::class);
        $response
            ->method('getStatusCode')
            ->willReturn(400);
        $response
            ->method('getBody')
            ->willReturn($stream);

        /** @var ResponseInterface $response */
        $exception = new LinodeException($response);

        self::assertSame(400, $exception->getCode());
        self::assertSame('Length must be 1-128 characters', $exception->getMessage());
        self::assertCount(2, $exception->getErrors());

        [$error1, $error2] = $exception->getErrors();

        self::assertSame('Length must be 1-128 characters', $error1->getReason());
        self::assertSame('label', $error1->getField());

        self::assertSame('Domain is required', $error2->getReason());
        self::assertSame('redirect_uri', $error2->getField());
    }

    public function testEmptyErrors()
    {
        $stream = $this->createMock(StreamInterface::class);
        $stream
            ->method('getContents')
            ->willReturn(null);

        $response = $this->createMock(ResponseInterface::class);
        $response
            ->method('getStatusCode')
            ->willReturn(400);
        $response
            ->method('getBody')
            ->willReturn($stream);

        /** @var ResponseInterface $response */
        $exception = new LinodeException($response);

        self::assertSame(400, $exception->getCode());
        self::assertSame('Unknown error', $exception->getMessage());
        self::assertCount(1, $exception->getErrors());

        [$error] = $exception->getErrors();

        self::assertSame('Unknown error', $error->getReason());
        self::assertNull($error->getField());
    }
}
