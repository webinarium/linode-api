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
use Linode\Entity\NodeBalancers\NodeBalancer;
use Linode\Entity\NodeBalancers\NodeBalancerConfig;
use Linode\Entity\NodeBalancers\NodeBalancerNode;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\NodeBalancers\NodeBalancerConfigRepositoryInterface;
use PHPUnit\Framework\TestCase;

class NodeBalancerConfigRepositoryTest extends TestCase
{
    use ReflectionTrait;

    /** @var NodeBalancerConfigRepository */
    protected $repository;

    protected function setUp()
    {
        $client = new LinodeClient();

        $this->repository = new NodeBalancerConfigRepository($client, 12345);
    }

    public function testCreate()
    {
        $request = [
            'json' => [
                'port'           => 80,
                'protocol'       => 'http',
                'algorithm'      => 'roundrobin',
                'stickiness'     => 'http_cookie',
                'check'          => 'http_body',
                'check_interval' => 90,
                'check_timeout'  => 10,
                'check_attempts' => 3,
                'check_path'     => '/test',
                'check_body'     => 'it works',
                'check_passive'  => true,
                'cipher_suite'   => 'recommended',
                'ssl_cert'       => null,
                'ssl_key'        => null,
            ],
        ];

        $response = <<<'JSON'
            {
                "id": 4567,
                "port": 80,
                "protocol": "http",
                "algorithm": "roundrobin",
                "stickiness": "http_cookie",
                "check": "http_body",
                "check_interval": 90,
                "check_timeout": 10,
                "check_attempts": 3,
                "check_path": "/test",
                "check_body": "it works",
                "check_passive": true,
                "cipher_suite": "recommended",
                "nodebalancer_id": 12345,
                "ssl_commonname": null,
                "ssl_fingerprint": null,
                "ssl_cert": null,
                "ssl_key": null,
                "nodes_status": {
                    "up": 4,
                    "down": 0
                }
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/nodebalancers/12345/configs', $request, new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->create([
            NodeBalancerConfig::FIELD_PORT           => 80,
            NodeBalancerConfig::FIELD_PROTOCOL       => 'http',
            NodeBalancerConfig::FIELD_ALGORITHM      => 'roundrobin',
            NodeBalancerConfig::FIELD_STICKINESS     => 'http_cookie',
            NodeBalancerConfig::FIELD_CHECK          => 'http_body',
            NodeBalancerConfig::FIELD_CHECK_INTERVAL => 90,
            NodeBalancerConfig::FIELD_CHECK_TIMEOUT  => 10,
            NodeBalancerConfig::FIELD_CHECK_ATTEMPTS => 3,
            NodeBalancerConfig::FIELD_CHECK_PATH     => '/test',
            NodeBalancerConfig::FIELD_CHECK_BODY     => 'it works',
            NodeBalancerConfig::FIELD_CHECK_PASSIVE  => true,
            NodeBalancerConfig::FIELD_CIPHER_SUITE   => 'recommended',
            NodeBalancerConfig::FIELD_SSL_CERT       => null,
            NodeBalancerConfig::FIELD_SSL_KEY        => null,
        ]);

        self::assertInstanceOf(NodeBalancerConfig::class, $entity);
        self::assertSame(4567, $entity->id);
        self::assertSame('roundrobin', $entity->algorithm);
    }

    public function testUpdate()
    {
        $request = [
            'json' => [
                'port'           => 80,
                'protocol'       => 'http',
                'algorithm'      => 'roundrobin',
                'stickiness'     => 'http_cookie',
                'check'          => 'http_body',
                'check_interval' => 90,
                'check_timeout'  => 10,
                'check_attempts' => 3,
                'check_path'     => '/test',
                'check_body'     => 'it works',
                'check_passive'  => true,
                'cipher_suite'   => 'recommended',
                'ssl_cert'       => null,
                'ssl_key'        => null,
            ],
        ];

        $response = <<<'JSON'
            {
                "id": 4567,
                "port": 80,
                "protocol": "http",
                "algorithm": "roundrobin",
                "stickiness": "http_cookie",
                "check": "http_body",
                "check_interval": 90,
                "check_timeout": 10,
                "check_attempts": 3,
                "check_path": "/test",
                "check_body": "it works",
                "check_passive": true,
                "cipher_suite": "recommended",
                "nodebalancer_id": 12345,
                "ssl_commonname": null,
                "ssl_fingerprint": null,
                "ssl_cert": null,
                "ssl_key": null,
                "nodes_status": {
                    "up": 4,
                    "down": 0
                }
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['PUT', 'https://api.linode.com/v4/nodebalancers/12345/configs/4567', $request, new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->update(4567, [
            NodeBalancerConfig::FIELD_PORT           => 80,
            NodeBalancerConfig::FIELD_PROTOCOL       => 'http',
            NodeBalancerConfig::FIELD_ALGORITHM      => 'roundrobin',
            NodeBalancerConfig::FIELD_STICKINESS     => 'http_cookie',
            NodeBalancerConfig::FIELD_CHECK          => 'http_body',
            NodeBalancerConfig::FIELD_CHECK_INTERVAL => 90,
            NodeBalancerConfig::FIELD_CHECK_TIMEOUT  => 10,
            NodeBalancerConfig::FIELD_CHECK_ATTEMPTS => 3,
            NodeBalancerConfig::FIELD_CHECK_PATH     => '/test',
            NodeBalancerConfig::FIELD_CHECK_BODY     => 'it works',
            NodeBalancerConfig::FIELD_CHECK_PASSIVE  => true,
            NodeBalancerConfig::FIELD_CIPHER_SUITE   => 'recommended',
            NodeBalancerConfig::FIELD_SSL_CERT       => null,
            NodeBalancerConfig::FIELD_SSL_KEY        => null,
        ]);

        self::assertInstanceOf(NodeBalancerConfig::class, $entity);
        self::assertSame(4567, $entity->id);
        self::assertSame('roundrobin', $entity->algorithm);
    }

    public function testDelete()
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['DELETE', 'https://api.linode.com/v4/nodebalancers/12345/configs/4567', [], new Response(200, [], null)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $repository->delete(4567);

        self::assertTrue(true);
    }

    public function testRebuild()
    {
        $request = [
            'json' => [
                'configs' => [
                    [
                        'port'           => 80,
                        'protocol'       => 'http',
                        'algorithm'      => 'roundrobin',
                        'stickiness'     => 'http_cookie',
                        'check'          => 'http_body',
                        'check_interval' => 90,
                        'check_timeout'  => 10,
                        'check_attempts' => 3,
                        'check_path'     => '/test',
                        'check_body'     => 'it works',
                        'check_passive'  => true,
                        'cipher_suite'   => 'recommended',
                        'ssl_cert'       => null,
                        'ssl_key'        => null,
                        'nodes'          => [
                            [
                                'address' => '192.168.210.120=>80',
                                'label'   => 'node54321',
                                'weight'  => 50,
                                'mode'    => 'accept',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $response = <<<'JSON'
            {
                "id": 12345,
                "label": "balancer12345",
                "region": "us-east",
                "hostname": "nb-207-192-68-16.newark.nodebalancer.linode.com",
                "ipv4": "12.34.56.78",
                "ipv6": null,
                "created": "2018-01-01T00:01:01.000Z",
                "updated": "2018-03-01T00:01:01.000Z",
                "client_conn_throttle": 0,
                "transfer": {
                    "total": 32.46078109741211,
                    "out": 3.5487728118896484,
                    "in": 28.91200828552246
                }
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/nodebalancers/12345/configs/4567/rebuild', $request, new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->rebuild(4567, [
            NodeBalancer::FIELD_CONFIGS => [
                [
                    NodeBalancerConfig::FIELD_PORT           => 80,
                    NodeBalancerConfig::FIELD_PROTOCOL       => 'http',
                    NodeBalancerConfig::FIELD_ALGORITHM      => 'roundrobin',
                    NodeBalancerConfig::FIELD_STICKINESS     => 'http_cookie',
                    NodeBalancerConfig::FIELD_CHECK          => 'http_body',
                    NodeBalancerConfig::FIELD_CHECK_INTERVAL => 90,
                    NodeBalancerConfig::FIELD_CHECK_TIMEOUT  => 10,
                    NodeBalancerConfig::FIELD_CHECK_ATTEMPTS => 3,
                    NodeBalancerConfig::FIELD_CHECK_PATH     => '/test',
                    NodeBalancerConfig::FIELD_CHECK_BODY     => 'it works',
                    NodeBalancerConfig::FIELD_CHECK_PASSIVE  => true,
                    NodeBalancerConfig::FIELD_CIPHER_SUITE   => 'recommended',
                    NodeBalancerConfig::FIELD_SSL_CERT       => null,
                    NodeBalancerConfig::FIELD_SSL_KEY        => null,
                    NodeBalancerConfig::FIELD_NODES          => [
                        [
                            NodeBalancerNode::FIELD_ADDRESS => '192.168.210.120=>80',
                            NodeBalancerNode::FIELD_LABEL   => 'node54321',
                            NodeBalancerNode::FIELD_WEIGHT  => 50,
                            NodeBalancerNode::FIELD_MODE    => 'accept',
                        ],
                    ],
                ],
            ],
        ]);

        self::assertInstanceOf(NodeBalancer::class, $entity);
        self::assertSame(12345, $entity->id);
        self::assertSame('balancer12345', $entity->label);
    }

    public function testGetBaseUri()
    {
        $expected = '/nodebalancers/12345/configs';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields()
    {
        $expected = [
            'id',
            'port',
            'protocol',
            'algorithm',
            'stickiness',
            'check',
            'check_interval',
            'check_timeout',
            'check_attempts',
            'check_path',
            'check_body',
            'check_passive',
            'cipher_suite',
            'ssl_commonname',
            'ssl_fingerprint',
            'ssl_cert',
            'ssl_key',
            'nodes',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity()
    {
        self::assertInstanceOf(NodeBalancerConfig::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): NodeBalancerConfigRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new NodeBalancerConfigRepository($linodeClient, 12345);
    }
}
