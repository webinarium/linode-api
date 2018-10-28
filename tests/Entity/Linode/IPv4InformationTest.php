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
use Linode\LinodeClient;
use PHPUnit\Framework\TestCase;

class IPv4InformationTest extends TestCase
{
    protected $client;

    protected function setUp()
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties()
    {
        $entity = new IPv4Information($this->client, [
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
        ]);

        self::assertCount(1, $entity->public);
        self::assertInstanceOf(IPAddress::class, $entity->public[0]);
        self::assertSame('97.107.143.141', $entity->public[0]->address);
        self::assertTrue($entity->public[0]->public);

        self::assertCount(1, $entity->private);
        self::assertInstanceOf(IPAddress::class, $entity->private[0]);
        self::assertSame('192.168.133.234', $entity->private[0]->address);
        self::assertFalse($entity->private[0]->public);

        self::assertCount(1, $entity->shared);
        self::assertInstanceOf(IPAddress::class, $entity->shared[0]);
        self::assertSame('97.107.143.141', $entity->shared[0]->address);
        self::assertTrue($entity->shared[0]->public);

        /** @noinspection PhpUndefinedFieldInspection */
        self::assertNull($entity->unknown);
    }
}
