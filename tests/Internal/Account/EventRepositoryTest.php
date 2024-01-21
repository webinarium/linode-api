<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal\Account;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Linode\Entity\Account\Event;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Account\EventRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\Account\EventRepository
 */
final class EventRepositoryTest extends TestCase
{
    use ReflectionTrait;

    protected EventRepositoryInterface $repository;

    protected function setUp(): void
    {
        $client = new LinodeClient();

        $this->repository = new EventRepository($client);
    }

    public function testMarkAsSeen(): void
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/account/events/123/seen', [], new Response(200, [], null)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $repository->markAsSeen(123);

        self::assertTrue(true);
    }

    public function testMarkAsRead(): void
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/account/events/123/read', [], new Response(200, [], null)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $repository->markAsRead(123);

        self::assertTrue(true);
    }

    public function testGetBaseUri(): void
    {
        $expected = '/account/events';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields(): void
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

    public function testJsonToEntity(): void
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
