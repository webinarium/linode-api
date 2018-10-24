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

namespace Linode\Internal;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Linode\Entity\Entity;
use Linode\Exception\LinodeException;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use PHPUnit\Framework\TestCase;

class AbstractRepositoryTest extends TestCase
{
    use ReflectionTrait;

    /** @var AbstractRepository */
    protected $repository;

    protected function setUp()
    {
        $entity = [
            'name'   => 'February',
            'season' => 'Winter',
            'days'   => 28,
        ];

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

        $filtered = [
            'page'    => 1,
            'pages'   => 1,
            'results' => 7,
            'data'    => [
                ['name' => 'January',  'season' => 'Winter', 'days' => 31],
                ['name' => 'March',    'season' => 'Spring', 'days' => 31],
                ['name' => 'May',      'season' => 'Spring', 'days' => 31],
                ['name' => 'July',     'season' => 'Summer', 'days' => 31],
                ['name' => 'August',   'season' => 'Summer', 'days' => 31],
                ['name' => 'October',  'season' => 'Autumn', 'days' => 31],
                ['name' => 'December', 'season' => 'Winter', 'days' => 31],
            ],
        ];

        $filteredAndSorted = [
            'page'    => 1,
            'pages'   => 1,
            'results' => 7,
            'data'    => [
                ['name' => 'August',   'season' => 'Summer', 'days' => 31],
                ['name' => 'December', 'season' => 'Winter', 'days' => 31],
                ['name' => 'January',  'season' => 'Winter', 'days' => 31],
                ['name' => 'July',     'season' => 'Summer', 'days' => 31],
                ['name' => 'March',    'season' => 'Spring', 'days' => 31],
                ['name' => 'May',      'season' => 'Spring', 'days' => 31],
                ['name' => 'October',  'season' => 'Autumn', 'days' => 31],
            ],
        ];

        $single = [
            'page'    => 1,
            'pages'   => 1,
            'results' => 1,
            'data'    => [
                ['name' => 'February', 'season' => 'Winter', 'days' => 28],
            ],
        ];

        $zero = [
            'page'    => 1,
            'pages'   => 1,
            'results' => 0,
            'data'    => [],
        ];

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['GET', 'https://api.linode.com/v4/test/2', [], new Response(200, [], json_encode($entity))],
                ['GET', 'https://api.linode.com/v4/test', ['query' => ['page' => 1]], new Response(200, [], json_encode($all))],
                ['GET', 'https://api.linode.com/v4/test', ['headers' => ['X-Filter' => '{"+order_by":"name","+order":"asc"}'], 'query' => ['page' => 1]], new Response(200, [], json_encode($sorted))],
                ['GET', 'https://api.linode.com/v4/test', ['headers' => ['X-Filter' => '{"days":31}'], 'query' => ['page' => 1]], new Response(200, [], json_encode($filtered))],
                ['GET', 'https://api.linode.com/v4/test', ['headers' => ['X-Filter' => '{"days":31,"+order_by":"name","+order":"asc"}'], 'query' => ['page' => 1]], new Response(200, [], json_encode($filteredAndSorted))],
                ['GET', 'https://api.linode.com/v4/test', ['headers' => ['X-Filter' => '{"days":28}'], 'query' => ['page' => 1]], new Response(200, [], json_encode($single))],
                ['GET', 'https://api.linode.com/v4/test', ['headers' => ['X-Filter' => '{"days":29}'], 'query' => ['page' => 1]], new Response(200, [], json_encode($zero))],
            ]);

        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        $this->repository = new class($linodeClient) extends AbstractRepository {
            protected function getBaseUri(): string
            {
                return '/test';
            }

            protected function getSupportedFields(): array
            {
                return ['days', 'name', 'season'];
            }

            protected function jsonToEntity(array $json): Entity
            {
                return new class($this->client, $json) extends Entity {};
            }
        };
    }

    public function testFind()
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $this->repository->find(2);

        self::assertInstanceOf(Entity::class, $entity);
        self::assertSame('February', $entity->name);
    }

    public function testFindAll()
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $collection = $this->repository->findAll();

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
        /** @noinspection PhpUnhandledExceptionInspection */
        $collection = $this->repository->findAll('name');

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

    public function testFindBy()
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $collection = $this->repository->findBy([
            'days' => 31,
        ]);

        self::assertCount(7, $collection);

        $expected = [
            'January',
            'March',
            'May',
            'July',
            'August',
            'October',
            'December',
        ];

        foreach ($collection as $index => $entity) {
            self::assertInstanceOf(Entity::class, $entity);
            self::assertSame($expected[$index], $entity->name);
        }
    }

    public function testFindBySorted()
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $collection = $this->repository->findBy([
            'days' => 31,
        ], 'name');

        self::assertCount(7, $collection);

        $expected = [
            'August',
            'December',
            'January',
            'July',
            'March',
            'May',
            'October',
        ];

        foreach ($collection as $index => $entity) {
            self::assertInstanceOf(Entity::class, $entity);
            self::assertSame($expected[$index], $entity->name);
        }
    }

    public function testFindOneBy()
    {
        $data = [
            'name'   => 'February',
            'season' => 'Winter',
            'days'   => 28,
        ];

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $this->repository->findOneBy([
            'days' => 28,
        ]);

        self::assertInstanceOf(Entity::class, $entity);
        self::assertSame($data, $entity->toArray());
    }

    public function testFindOneByZero()
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $this->repository->findOneBy([
            'days' => 29,
        ]);

        self::assertNull($entity);
    }

    public function testFindOneByException()
    {
        $this->expectException(LinodeException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('More than one entity was found');

        /** @noinspection PhpUnhandledExceptionInspection */
        $this->repository->findOneBy([
            'days' => 31,
        ]);
    }

    public function testQuery()
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $collection = $this->repository->query('days == :number', [
            'number' => 31,
        ]);

        self::assertCount(7, $collection);

        $expected = [
            'January',
            'March',
            'May',
            'July',
            'August',
            'October',
            'December',
        ];

        foreach ($collection as $index => $entity) {
            self::assertInstanceOf(Entity::class, $entity);
            self::assertSame($expected[$index], $entity->name);
        }
    }

    public function testQuerySorted()
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $collection = $this->repository->query('days == :number', [
            'number' => 31,
        ], 'name');

        self::assertCount(7, $collection);

        $expected = [
            'August',
            'December',
            'January',
            'July',
            'March',
            'May',
            'October',
        ];

        foreach ($collection as $index => $entity) {
            self::assertInstanceOf(Entity::class, $entity);
            self::assertSame($expected[$index], $entity->name);
        }
    }

    public function testQueryException()
    {
        $this->expectException(LinodeException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Invalid expression');

        /** @noinspection PhpUnhandledExceptionInspection */
        $this->repository->query('days');
    }

    public function testCheckParametersSupportSuccess()
    {
        $parameters = [
            'season' => 'Summer',
            'days'   => 31,
        ];

        $this->callMethod($this->repository, 'checkParametersSupport', [$parameters]);
        self::assertTrue(true);
    }

    public function testCheckParametersSupportException()
    {
        $this->expectException(LinodeException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Unknown field(s): year, city');

        $parameters = [
            'season' => 'Summer',
            'year'   => 2004,
            'days'   => 31,
            'city'   => 'Auckland',
        ];

        $this->callMethod($this->repository, 'checkParametersSupport', [$parameters]);
        self::assertTrue(true);
    }
}
