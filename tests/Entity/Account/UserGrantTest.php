<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity\Account;

use Linode\LinodeClient;
use PHPUnit\Framework\TestCase;

class UserGrantTest extends TestCase
{
    protected $client;

    protected function setUp()
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties()
    {
        $entity = new UserGrant($this->client, [
            'global'       => [
                'add_linodes'           => true,
                'add_longview'          => true,
                'longview_subscription' => true,
                'account_access'        => 'read_only',
                'cancel_account'        => false,
                'add_domains'           => true,
                'add_stackscripts'      => true,
                'add_nodebalancers'     => true,
                'add_images'            => true,
                'add_volumes'           => true,
            ],
            'linode'       => [
                [
                    'id'          => 123,
                    'permissions' => 'read_only',
                    'label'       => 'example-entity',
                ],
            ],
            'domain'       => [
                [
                    'id'          => 123,
                    'permissions' => 'read_only',
                    'label'       => 'example-entity',
                ],
            ],
            'nodebalancer' => [
                [
                    'id'          => 123,
                    'permissions' => 'read_only',
                    'label'       => 'example-entity',
                ],
            ],
            'image'        => [
                [
                    'id'          => 123,
                    'permissions' => 'read_only',
                    'label'       => 'example-entity',
                ],
            ],
            'longview'     => [
                [
                    'id'          => 123,
                    'permissions' => 'read_only',
                    'label'       => 'example-entity',
                ],
            ],
            'stackscript'  => [
                [
                    'id'          => 123,
                    'permissions' => 'read_only',
                    'label'       => 'example-entity',
                ],
            ],
            'volume'       => [
                [
                    'id'          => 123,
                    'permissions' => 'read_only',
                    'label'       => 'example-entity',
                ],
            ],
        ]);

        self::assertInstanceOf(GlobalGrant::class, $entity->global);

        self::assertCount(1, $entity->linode);
        self::assertInstanceOf(Grant::class, $entity->linode[0]);
        self::assertSame(123, $entity->linode[0]->id);
        self::assertSame('read_only', $entity->linode[0]->permissions);
        self::assertSame('example-entity', $entity->linode[0]->label);

        self::assertCount(1, $entity->domain);
        self::assertInstanceOf(Grant::class, $entity->domain[0]);
        self::assertSame(123, $entity->domain[0]->id);
        self::assertSame('read_only', $entity->domain[0]->permissions);
        self::assertSame('example-entity', $entity->domain[0]->label);

        self::assertCount(1, $entity->nodebalancer);
        self::assertInstanceOf(Grant::class, $entity->nodebalancer[0]);
        self::assertSame(123, $entity->nodebalancer[0]->id);
        self::assertSame('read_only', $entity->nodebalancer[0]->permissions);
        self::assertSame('example-entity', $entity->nodebalancer[0]->label);

        self::assertCount(1, $entity->image);
        self::assertInstanceOf(Grant::class, $entity->image[0]);
        self::assertSame(123, $entity->image[0]->id);
        self::assertSame('read_only', $entity->image[0]->permissions);
        self::assertSame('example-entity', $entity->image[0]->label);

        self::assertCount(1, $entity->longview);
        self::assertInstanceOf(Grant::class, $entity->longview[0]);
        self::assertSame(123, $entity->longview[0]->id);
        self::assertSame('read_only', $entity->longview[0]->permissions);
        self::assertSame('example-entity', $entity->longview[0]->label);

        self::assertCount(1, $entity->stackscript);
        self::assertInstanceOf(Grant::class, $entity->stackscript[0]);
        self::assertSame(123, $entity->stackscript[0]->id);
        self::assertSame('read_only', $entity->stackscript[0]->permissions);
        self::assertSame('example-entity', $entity->stackscript[0]->label);

        self::assertCount(1, $entity->volume);
        self::assertInstanceOf(Grant::class, $entity->volume[0]);
        self::assertSame(123, $entity->volume[0]->id);
        self::assertSame('read_only', $entity->volume[0]->permissions);
        self::assertSame('example-entity', $entity->volume[0]->label);

        /** @noinspection PhpUndefinedFieldInspection */
        self::assertNull($entity->unknown);
    }
}
