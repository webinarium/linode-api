<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal\Account;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Linode\Entity\Account\Event;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Account\EventRepositoryInterface;
use PHPUnit\Framework\TestCase;

class EventRepositoryTest extends TestCase
{
    use ReflectionTrait;

    /** @var EventRepository */
    protected $repository;

    protected function setUp()
    {
        $client = new LinodeClient();

        $this->repository = new EventRepository($client);
    }

    public function testMarkAsSeen()
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/account/events/123/seen', [], new Response(200, [], null)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $repository->markAsSeen(123);

        self::assertTrue(true);
    }

    public function testMarkAsRead()
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/account/events/123/read', [], new Response(200, [], null)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $repository->markAsRead(123);

        self::assertTrue(true);
    }

    public function testGetBaseUri()
    {
        $expected = '/account/events';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields()
    {
        $expected = [
            'id',
            'username',
            'action',
            'created',
            'status',
            'seen',
            'read',
            'rate',
            'percent_complete',
            'time_remaining',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity()
    {
        self::assertInstanceOf(Event::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): EventRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new EventRepository($linodeClient);
    }
}
