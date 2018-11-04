<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity\NodeBalancers;

use Linode\Internal\NodeBalancers\NodeBalancerConfigRepository;
use Linode\LinodeClient;
use PHPUnit\Framework\TestCase;

class NodeBalancerTest extends TestCase
{
    protected $client;

    protected function setUp()
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties()
    {
        $data = [
            'id'                   => 12345,
            'label'                => 'balancer12345',
            'region'               => 'us-east',
            'hostname'             => 'nb-207-192-68-16.newark.nodebalancer.linode.com',
            'ipv4'                 => '12.34.56.78',
            'ipv6'                 => null,
            'created'              => '2018-01-01T00:01:01.000Z',
            'updated'              => '2018-03-01T00:01:01.000Z',
            'client_conn_throttle' => 0,
            'transfer'             => [
                'total' => 32.46078109741211,
                'out'   => 3.5487728118896484,
                'in'    => 28.91200828552246,
            ],
        ];

        $entity = new NodeBalancer($this->client, $data);

        self::assertInstanceOf(NodeTransfer::class, $entity->transfer);
        self::assertSame(32.46078109741211, $entity->transfer->total);
        self::assertSame('balancer12345', $entity->label);

        self::assertInstanceOf(NodeBalancerConfigRepository::class, $entity->configs);
    }
}
