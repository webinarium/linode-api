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

class AbstractRepositoryTest extends TestCase
{
    /** @var Client */
    protected $client;

    protected function setUp()
    {
        $all = [
            'page'    => 1,
            'pages'   => 1,
            'results' => 12,
            'data'    => [
                ['name' => 'January',   'season' => 'Winter', 'days' => 31],
                ['name' => 'February',  'season' => 'Winter', 'days' => 28],
                ['name' => 'March',     'season' => 'Spring', 'days' => 31],
                ['name' => 'April',     'season' => 'Spring', 'days' => 30],
                ['name' => 'May',       'season' => 'Spring', 'days' => 31],
                ['name' => 'June',      'season' => 'Summer', 'days' => 30],
                ['name' => 'July',      'season' => 'Summer', 'days' => 31],
                ['name' => 'August',    'season' => 'Summer', 'days' => 31],
                ['name' => 'September', 'season' => 'Autumn', 'days' => 30],
                ['name' => 'October',   'season' => 'Autumn', 'days' => 31],
                ['name' => 'November',  'season' => 'Autumn', 'days' => 30],
                ['name' => 'December',  'season' => 'Winter', 'days' => 31],
            ],
        ];

        $sorted = [
            'page'    => 1,
            'pages'   => 1,
            'results' => 12,
            'data'    => [
                ['name' => 'April',     'season' => 'Spring', 'days' => 30],
                ['name' => 'August',    'season' => 'Summer', 'days' => 31],
                ['name' => 'December',  'season' => 'Winter', 'days' => 31],
                ['name' => 'February',  'season' => 'Winter', 'days' => 28],
                ['name' => 'January',   'season' => 'Winter', 'days' => 31],
                ['name' => 'July',      'season' => 'Summer', 'days' => 31],
                ['name' => 'June',      'season' => 'Summer', 'days' => 30],
                ['name' => 'March',     'season' => 'Spring', 'days' => 31],
                ['name' => 'May',       'season' => 'Spring', 'days' => 31],
                ['name' => 'November',  'season' => 'Autumn', 'days' => 30],
                ['name' => 'October',   'season' => 'Autumn', 'days' => 31],
                ['name' => 'September', 'season' => 'Autumn', 'days' => 30],
            ],
        ];

        $this->client = $this->createMock(Client::class);
        $this->client
            ->method('request')
            ->willReturnMap([
                ['GET', 'http://localhost/entries', ['query' => ['page' => 1]], new Response(200, [], json_encode($all))],
                ['GET', 'http://localhost/entries', ['headers' => ['X-Filter' => '{"+order_by":"name","+order":"asc"}'], 'query' => ['page' => 1]], new Response(200, [], json_encode($sorted))],
            ]);
    }

    public function testFind()
    {
        $data = [
            'id'          => 'g6-standard-1',
            'label'       => 'Linode 2GB',
            'class'       => 'standard',
            'vcpus'       => 1,
            'price'       => [
                'hourly'  => 0.015,
                'monthly' => 10,
            ],
        ];

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturn(new Response(200, [], json_encode($data)));

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->find(123);

        self::assertInstanceOf(Entity::class, $entity);
        self::assertSame('standard', $entity->class);
        self::assertSame($data, $entity->toArray());
    }

    public function testFindAll()
    {
        $repository = $this->mockRepository($this->client);
        $collection = $repository->findAll();

        self::assertCount(12, $collection);

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

        foreach ($collection as $index => $entity) {
            self::assertInstanceOf(Entity::class, $entity);
            self::assertSame($expected[$index], $entity->name);
        }
    }

    public function testFindAllSorted()
    {
        $repository = $this->mockRepository($this->client);
        $collection = $repository->findAll('name');

        self::assertCount(12, $collection);

        $expected = [
            'April',
            'August',
            'December',
            'February',
            'January',
            'July',
            'June',
            'March',
            'May',
            'November',
            'October',
            'September',
        ];

        foreach ($collection as $index => $entity) {
            self::assertInstanceOf(Entity::class, $entity);
            self::assertSame($expected[$index], $entity->name);
        }
    }

    protected function mockRepository(Client $client)
    {
        return new class($client) extends AbstractRepository {
            use ApiTrait;

            public function __construct(Client $client)
            {
                parent::__construct();

                $this->client   = $client;
                $this->base_uri = 'http://localhost/entries';
            }

            protected function jsonToEntity(array $json): Entity
            {
                return new class($json) extends Entity {};
            }
        };
    }
}
