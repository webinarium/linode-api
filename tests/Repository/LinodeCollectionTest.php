<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

/** @noinspection PhpUndefinedMethodInspection */

namespace Linode\Repository;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Linode\Entity\Entity;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use PHPUnit\Framework\TestCase;

class LinodeCollectionTest extends TestCase
{
    use ReflectionTrait;

    protected $repository;

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

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['GET', 'https://api.linode.com/v4/test', ['query' => ['page' => 1]], new Response(200, [], json_encode($page1))],
                ['GET', 'https://api.linode.com/v4/test', ['query' => ['page' => 2]], new Response(200, [], json_encode($page2))],
            ]);

        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        $this->repository = new class($linodeClient) extends AbstractRepository {
            // Overload to fake.
            //protected const BASE_API_URI = '/test';

            public function getCollection(): LinodeCollection
            {
                return new LinodeCollection(
                    function (int $page) {
                        return $this->client->api($this->client::REQUEST_GET, '/test', ['page' => $page]);
                    },
                    function (array $json) {
                        return $this->jsonToEntity($json);
                    });
            }

            protected function getSupportedFields(): array
            {
                return [];
            }

            protected function jsonToEntity(array $json): Entity
            {
                return new class($this->client, $json) extends Entity {};
            }
        };
    }

    public function testCountable()
    {
        $collection = $this->repository->getCollection();

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

        $collection = $this->repository->getCollection();

        $actual = [];

        foreach ($collection as $key => $entity) {
            $actual[$key] = $entity->name;
        }

        self::assertSame($expected, $actual);
    }
}
