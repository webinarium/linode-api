<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity\NodeBalancers;

use Linode\Internal\NodeBalancers\NodeBalancerNodeRepository;
use Linode\LinodeClient;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Entity\NodeBalancers\NodeBalancerConfig
 */
final class NodeBalancerConfigTest extends TestCase
{
    protected LinodeClient $client;

    protected function setUp(): void
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties(): void
    {
        $data = [
            'id'              => 4567,
            'port'            => 80,
            'protocol'        => 'http',
            'algorithm'       => 'roundrobin',
            'stickiness'      => 'http_cookie',
            'check'           => 'http_body',
            'check_interval'  => 90,
            'check_timeout'   => 10,
            'check_attempts'  => 3,
            'check_path'      => '/test',
            'check_body'      => 'it works',
            'check_passive'   => true,
            'cipher_suite'    => 'recommended',
            'nodebalancer_id' => 12345,
            'ssl_commonname'  => null,
            'ssl_fingerprint' => null,
            'ssl_cert'        => null,
            'ssl_key'         => null,
            'nodes_status'    => [
                'up'   => 4,
                'down' => 0,
            ],
        ];

        $entity = new NodeBalancerConfig($this->client, $data);

        self::assertInstanceOf(NodesStatus::class, $entity->nodes_status);
        self::assertSame(4, $entity->nodes_status->up);
        self::assertSame(0, $entity->nodes_status->down);
        self::assertSame(4567, $entity->id);

        self::assertInstanceOf(NodeBalancerNodeRepository::class, $entity->nodes);
    }
}
