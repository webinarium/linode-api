<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity\Linode;

use Linode\LinodeClient;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Entity\Linode\NetworkInformation
 */
final class NetworkInformationTest extends TestCase
{
    protected LinodeClient $client;

    protected function setUp(): void
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties(): void
    {
        $data = [
            'ipv4' => [
                'public'  => [
                    [
                        'address'     => '97.107.143.141',
                        'gateway'     => '97.107.143.1',
                        'subnet_mask' => '255.255.255.0',
                        'prefix'      => 24,
                        'type'        => 'ipv4',
                        'public'      => true,
                        'rdns'        => 'test.example.org',
                        'linode_id'   => 123,
                        'region'      => 'us-east',
                    ],
                ],
                'private' => [
                    [
                        'address'     => '192.168.133.234',
                        'gateway'     => null,
                        'subnet_mask' => '255.255.128.0',
                        'prefix'      => 17,
                        'type'        => 'ipv4',
                        'public'      => false,
                        'rdns'        => null,
                        'linode_id'   => 123,
                        'region'      => 'us-east',
                    ],
                ],
                'shared'  => [
                    [
                        'address'     => '97.107.143.141',
                        'gateway'     => '97.107.143.1',
                        'subnet_mask' => '255.255.255.0',
                        'prefix'      => 24,
                        'type'        => 'ipv4',
                        'public'      => true,
                        'rdns'        => 'test.example.org',
                        'linode_id'   => 123,
                        'region'      => 'us-east',
                    ],
                ],
            ],
            'ipv6' => [
                'link_local' => [
                    'address'     => 'fe80::f03c:91ff:fe24:3a2f',
                    'gateway'     => 'fe80::1',
                    'subnet_mask' => 'ffff:ffff:ffff:ffff:ffff:ffff:ffff:ffff',
                    'prefix'      => 64,
                    'type'        => 'ipv6',
                    'public'      => false,
                    'rdns'        => null,
                    'linode_id'   => 123,
                    'region'      => 'us-east',
                ],
                'slaac'      => [
                    'address'     => '2600:3c03::f03c:91ff:fe24:3a2f',
                    'gateway'     => 'fe80::1',
                    'subnet_mask' => 'ffff:ffff:ffff:ffff:ffff:ffff:ffff:ffff',
                    'prefix'      => 64,
                    'type'        => 'ipv6',
                    'public'      => true,
                    'rdns'        => null,
                    'linode_id'   => 123,
                    'region'      => 'us-east',
                ],
                'global'     => [
                    'range'  => '2600:3c01::02:5000::',
                    'region' => 'us-east',
                ],
            ],
        ];

        $entity = new NetworkInformation($this->client, $data);

        self::assertInstanceOf(IPv4Information::class, $entity->ipv4);
        self::assertCount(1, $entity->ipv4->public);

        self::assertInstanceOf(IPv6Information::class, $entity->ipv6);
        self::assertSame('2600:3c01::02:5000::', $entity->ipv6->global->range);

        self::assertNull($entity->unknown);
    }
}
