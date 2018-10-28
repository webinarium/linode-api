<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity\Linode;

use Linode\Entity\Networking\IPAddress;
use Linode\Entity\Networking\IPv6Pool;
use Linode\LinodeClient;
use PHPUnit\Framework\TestCase;

class IPv6InformationTest extends TestCase
{
    protected $client;

    protected function setUp()
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties()
    {
        $data = [
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
        ];

        $entity = new IPv6Information($this->client, $data);

        self::assertInstanceOf(IPAddress::class, $entity->link_local);
        self::assertSame('fe80::f03c:91ff:fe24:3a2f', $entity->link_local->address);

        self::assertInstanceOf(IPAddress::class, $entity->slaac);
        self::assertSame('2600:3c03::f03c:91ff:fe24:3a2f', $entity->slaac->address);

        self::assertInstanceOf(IPv6Pool::class, $entity->global);
        self::assertSame('2600:3c01::02:5000::', $entity->global->range);

        /** @noinspection PhpUndefinedFieldInspection */
        self::assertNull($entity->unknown);
    }
}
