<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal\Account;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Linode\Entity\Account\GlobalGrant;
use Linode\Entity\Account\Grant;
use Linode\Entity\Account\User;
use Linode\Entity\Account\UserGrant;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Account\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    use ReflectionTrait;

    /** @var UserRepository */
    protected $repository;

    protected function setUp()
    {
        $client = new LinodeClient();

        $this->repository = new UserRepository($client);
    }

    public function testCreate()
    {
        $request = [
            'json' => [
                'username'   => 'example_user',
                'email'      => 'example_user@linode.com',
                'restricted' => true,
            ],
        ];

        $response = <<<'JSON'
            {
                "username": "example_user",
                "email": "example_user@linode.com",
                "restricted": true,
                "ssh_keys": [
                    "home-pc",
                    "laptop"
                ]
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/account/users', $request, new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->create([
            User::FIELD_USERNAME   => 'example_user',
            User::FIELD_EMAIL      => 'example_user@linode.com',
            User::FIELD_RESTRICTED => true,
        ]);

        self::assertInstanceOf(User::class, $entity);
        self::assertSame('example_user', $entity->username);
        self::assertSame('example_user@linode.com', $entity->email);
    }

    public function testUpdate()
    {
        $request = [
            'json' => [
                'username'   => 'example_user',
                'restricted' => true,
                'ssh_keys'   => [
                    'home-pc',
                    'laptop',
                ],
            ],
        ];

        $response = <<<'JSON'
            {
                "username": "example_user",
                "email": "example_user@linode.com",
                "restricted": true,
                "ssh_keys": [
                    "home-pc",
                    "laptop"
                ]
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['PUT', 'https://api.linode.com/v4/account/users/example_user', $request, new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->update('example_user', [
            User::FIELD_USERNAME   => 'example_user',
            User::FIELD_RESTRICTED => true,
            User::FIELD_SSH_KEYS   => [
                'home-pc',
                'laptop',
            ],
        ]);

        self::assertInstanceOf(User::class, $entity);
        self::assertSame('example_user', $entity->username);
        self::assertSame('example_user@linode.com', $entity->email);
    }

    public function testDelete()
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['DELETE', 'https://api.linode.com/v4/account/users/example_user', [], new Response(200, [], null)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $repository->delete('example_user');

        self::assertTrue(true);
    }

    public function testGetUserGrants()
    {
        $response = <<<'JSON'
            {
                "global": {
                    "add_linodes": true,
                    "add_longview": true,
                    "longview_subscription": true,
                    "account_access": "read_only",
                    "cancel_account": false,
                    "add_domains": true,
                    "add_stackscripts": true,
                    "add_nodebalancers": true,
                    "add_images": true,
                    "add_volumes": true
                },
                "linode": [
                    {
                        "id": 123,
                        "permissions": "read_only",
                        "label": "example-entity"
                    }
                ],
                "domain": [
                    {
                        "id": 123,
                        "permissions": "read_only",
                        "label": "example-entity"
                    }
                ],
                "nodebalancer": [
                    {
                        "id": 123,
                        "permissions": "read_only",
                        "label": "example-entity"
                    }
                ],
                "image": [
                    {
                        "id": 123,
                        "permissions": "read_only",
                        "label": "example-entity"
                    }
                ],
                "longview": [
                    {
                        "id": 123,
                        "permissions": "read_only",
                        "label": "example-entity"
                    }
                ],
                "stackscript": [
                    {
                        "id": 123,
                        "permissions": "read_only",
                        "label": "example-entity"
                    }
                ],
                "volume": [
                    {
                        "id": 123,
                        "permissions": "read_only",
                        "label": "example-entity"
                    }
                ]
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['GET', 'https://api.linode.com/v4/account/users/example_user/grants', [], new Response(200, [], $response)],
                ['GET', 'https://api.linode.com/v4/account/users/super_admin/grants', [], new Response(204, [], null)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->getUserGrants('example_user');

        self::assertInstanceOf(UserGrant::class, $entity);
        self::assertInstanceOf(GlobalGrant::class, $entity->global);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->getUserGrants('super_admin');

        self::assertNull($entity);
    }

    public function testSetUserGrants()
    {
        $request = [
            'json' => [
                'global' => [
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
                'linode' => [
                    [
                        'id'          => 123,
                        'permissions' => 'read_only',
                    ],
                ],
            ],
        ];

        $response = <<<'JSON'
            {
                "global": {
                    "add_linodes": true,
                    "add_longview": true,
                    "longview_subscription": true,
                    "account_access": "read_only",
                    "cancel_account": false,
                    "add_domains": true,
                    "add_stackscripts": true,
                    "add_nodebalancers": true,
                    "add_images": true,
                    "add_volumes": true
                },
                "linode": [
                    {
                        "id": 123,
                        "permissions": "read_only",
                        "label": "example-entity"
                    }
                ],
                "domain": [
                    {
                        "id": 123,
                        "permissions": "read_only",
                        "label": "example-entity"
                    }
                ],
                "nodebalancer": [
                    {
                        "id": 123,
                        "permissions": "read_only",
                        "label": "example-entity"
                    }
                ],
                "image": [
                    {
                        "id": 123,
                        "permissions": "read_only",
                        "label": "example-entity"
                    }
                ],
                "longview": [
                    {
                        "id": 123,
                        "permissions": "read_only",
                        "label": "example-entity"
                    }
                ],
                "stackscript": [
                    {
                        "id": 123,
                        "permissions": "read_only",
                        "label": "example-entity"
                    }
                ],
                "volume": [
                    {
                        "id": 123,
                        "permissions": "read_only",
                        "label": "example-entity"
                    }
                ]
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['PUT', 'https://api.linode.com/v4/account/users/example_user/grants', $request, new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->setUserGrants('example_user', [
            UserGrant::FIELD_GLOBAL => [
                GlobalGrant::FIELD_ADD_LINODES           => true,
                GlobalGrant::FIELD_ADD_LONGVIEW          => true,
                GlobalGrant::FIELD_LONGVIEW_SUBSCRIPTION => true,
                GlobalGrant::FIELD_ACCOUNT_ACCESS        => GlobalGrant::READ_ONLY,
                GlobalGrant::FIELD_CANCEL_ACCOUNT        => false,
                GlobalGrant::FIELD_ADD_DOMAINS           => true,
                GlobalGrant::FIELD_ADD_STACKSCRIPTS      => true,
                GlobalGrant::FIELD_ADD_NODEBALANCERS     => true,
                GlobalGrant::FIELD_ADD_IMAGES            => true,
                GlobalGrant::FIELD_ADD_VOLUMES           => true,
            ],
            UserGrant::FIELD_LINODE => [
                [
                    Grant::FIELD_ID          => 123,
                    Grant::FIELD_PERMISSIONS => Grant::READ_ONLY,
                ],
            ],
        ]);

        self::assertInstanceOf(UserGrant::class, $entity);
        self::assertInstanceOf(GlobalGrant::class, $entity->global);
    }

    public function testGetBaseUri()
    {
        $expected = '/account/users';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields()
    {
        $expected = [
            'username',
            'email',
            'restricted',
            'ssh_keys',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity()
    {
        self::assertInstanceOf(User::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): UserRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new UserRepository($linodeClient);
    }
}
