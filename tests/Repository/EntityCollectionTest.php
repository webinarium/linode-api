<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Repository;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Linode\Entity\Entity;
use Linode\Internal\AbstractRepository;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Repository\EntityCollection
 */
final class EntityCollectionTest extends TestCase
{
    use ReflectionTrait;

    protected RepositoryInterface $repository;

    protected function setUp(): void
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
            ])
        ;

        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        $this->repository = new class($linodeClient) extends AbstractRepository {
            protected function getBaseUri(): string
            {
                return '/test';
            }

            public function getCollection(): EntityCollection
            {
                return new EntityCollection(
                    fn (int $page) => $this->client->api($this->client::REQUEST_GET, $this->getBaseUri(), ['page' => $page]),
                    fn (array $json) => $this->jsonToEntity($json)
                );
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

    public function testCountable(): void
    {
        $collection = $this->repository->getCollection();

        self::assertCount(12, $collection);
    }

    public function testIterator(): void
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
