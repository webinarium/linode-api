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

    protected function mockRepository(Client $client)
    {
        return new class($client) extends AbstractRepository {
            use ApiTrait;

            public function __construct(Client $client)
            {
                parent::__construct('secret');

                $this->client = $client;
            }

            protected function jsonToEntity(array $json): Entity
            {
                return new class($json) extends Entity {};
            }
        };
    }
}
