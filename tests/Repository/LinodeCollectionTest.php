<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Repository;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Linode\Entity\Entity;
use Linode\Internal\ApiTrait;
use PHPUnit\Framework\TestCase;

class LinodeCollectionTest extends TestCase
{
    /** @var Client */
    protected $client;

    protected function setUp()
    {
        $page1 = [
            'page'    => 1,
            'pages'   => 2,
            'results' => 12,
            'data'    => [
                ['name' => 'January'],
                ['name' => 'February'],
                ['name' => 'March'],
                ['name' => 'April'],
                ['name' => 'May'],
                ['name' => 'June'],
                ['name' => 'July'],
                ['name' => 'August'],
                ['name' => 'September'],
                ['name' => 'October'],
            ],
        ];

        $page2 = [
            'page'    => 2,
            'pages'   => 2,
            'results' => 12,
            'data'    => [
                ['name' => 'November'],
                ['name' => 'December'],
            ],
        ];

        $this->client = $this->createMock(Client::class);
        $this->client
            ->method('request')
            ->willReturnMap([
                ['GET', 'http://localhost/entries', ['query' => ['page' => 1]], new Response(200, [], json_encode($page1))],
                ['GET', 'http://localhost/entries', ['query' => ['page' => 2]], new Response(200, [], json_encode($page2))],
            ]);
    }

    public function testCountable()
    {
        $repository = $this->mockRepository($this->client);
        $collection = $repository->getCollection();

        self::assertCount(12, $collection);
    }

    public function testIterator()
    {
        $expected = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December',
        ];

        $repository = $this->mockRepository($this->client);
        $collection = $repository->getCollection();

        $actual = [];

        foreach ($collection as $key => $entity) {
            $actual[$key] = $entity->name;
        }

        self::assertSame($expected, $actual);
    }

    protected function mockRepository(Client $client)
    {
        return new class($client) extends AbstractRepository {
            use ApiTrait;

            public function __construct(Client $client)
            {
                parent::__construct();

                $this->client   = $client;
                $this->base_uri = 'http://localhost';
            }

            public function getCollection(): LinodeCollection
            {
                return new LinodeCollection(
                    function (int $page) {
                        return $this->api(AbstractRepository::REQUEST_GET, '/entries', ['page' => $page]);
                    },
                    function (array $json) {
                        return $this->jsonToEntity($json);
                    });
            }

            protected function jsonToEntity(array $json): Entity
            {
                return new class($json) extends Entity {};
            }
        };
    }
}
