<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal\NodeBalancers;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Linode\Entity\NodeBalancers\NodeBalancerNode;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\NodeBalancers\NodeBalancerNodeRepositoryInterface;
use PHPUnit\Framework\TestCase;

class NodeBalancerNodeRepositoryTest extends TestCase
{
    use ReflectionTrait;

    /** @var NodeBalancerNodeRepository */
    protected $repository;

    protected function setUp()
    {
        $client = new LinodeClient();

        $this->repository = new NodeBalancerNodeRepository($client, 12345, 4567);
    }

    public function testCreate()
    {
        $request = [
            'json' => [
                'address' => '192.168.210.120:80',
                'label'   => 'node54321',
                'weight'  => 50,
                'mode'    => 'accept',
            ],
        ];

        $response = <<<'JSON'
            {
                "id": 54321,
                "address": "192.168.210.120:80",
                "label": "node54321",
                "status": "UP",
                "weight": 50,
                "mode": "accept",
                "config_id": 4567,
                "nodebalancer_id": 12345
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/nodebalancers/12345/configs/4567/nodes', $request, new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->create([
            NodeBalancerNode::FIELD_ADDRESS => '192.168.210.120:80',
            NodeBalancerNode::FIELD_LABEL   => 'node54321',
            NodeBalancerNode::FIELD_WEIGHT  => 50,
            NodeBalancerNode::FIELD_MODE    => 'accept',
        ]);

        self::assertInstanceOf(NodeBalancerNode::class, $entity);
        self::assertSame(54321, $entity->id);
        self::assertSame('node54321', $entity->label);
    }

    public function testUpdate()
    {
        $request = [
            'json' => [
                'address' => '192.168.210.120:80',
                'label'   => 'node54321',
                'weight'  => 50,
                'mode'    => 'accept',
            ],
        ];

        $response = <<<'JSON'
            {
                "id": 54321,
                "address": "192.168.210.120:80",
                "label": "node54321",
                "status": "UP",
                "weight": 50,
                "mode": "accept",
                "config_id": 4567,
                "nodebalancer_id": 12345
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['PUT', 'https://api.linode.com/v4/nodebalancers/12345/configs/4567/nodes/54321', $request, new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->update(54321, [
            NodeBalancerNode::FIELD_ADDRESS => '192.168.210.120:80',
            NodeBalancerNode::FIELD_LABEL   => 'node54321',
            NodeBalancerNode::FIELD_WEIGHT  => 50,
            NodeBalancerNode::FIELD_MODE    => 'accept',
        ]);

        self::assertInstanceOf(NodeBalancerNode::class, $entity);
        self::assertSame(54321, $entity->id);
        self::assertSame('node54321', $entity->label);
    }

    public function testDelete()
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['DELETE', 'https://api.linode.com/v4/nodebalancers/12345/configs/4567/nodes/54321', [], new Response(200, [], null)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $repository->delete(54321);

        self::assertTrue(true);
    }

    public function testGetBaseUri()
    {
        $expected = '/nodebalancers/12345/configs/4567/nodes';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields()
    {
        $expected = [
            'id',
            'label',
            'address',
            'status',
            'weight',
            'mode',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity()
    {
        self::assertInstanceOf(NodeBalancerNode::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): NodeBalancerNodeRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new NodeBalancerNodeRepository($linodeClient, 12345, 4567);
    }
}
