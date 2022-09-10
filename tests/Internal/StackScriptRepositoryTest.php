<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Linode\Entity\StackScript;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\StackScriptRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\StackScriptRepository
 */
final class StackScriptRepositoryTest extends TestCase
{
    use ReflectionTrait;

    protected StackScriptRepositoryInterface $repository;

    protected function setUp(): void
    {
        $client = new LinodeClient();

        $this->repository = new StackScriptRepository($client);
    }

    public function testCreate(): void
    {
        $request = [
            'json' => [
                'label'       => 'a-stackscript',
                'description' => "This StackScript installs and configures MySQL\n",
                'images'      => [
                    'linode/debian9',
                    'linode/debian8',
                ],
                'is_public'   => true,
                'rev_note'    => 'Set up MySQL',
                'script'      => "\"#!/bin/bash\"\n",
            ],
        ];

        $response = <<<'JSON'
                        {
                            "id": 10079,
                            "username": "myuser",
                            "user_gravatar_id": "a445b305abda30ebc766bc7fda037c37",
                            "label": "a-stackscript",
                            "description": "This StackScript installs and configures MySQL\n",
                            "images": [
                                "linode/debian9",
                                "linode/debian8"
                            ],
                            "deployments_total": 12,
                            "deployments_active": 1,
                            "is_public": true,
                            "created": "2018-01-01T00:01:01",
                            "updated": "2018-01-01T00:01:01",
                            "rev_note": "Set up MySQL",
                            "script": "\"#!/bin/bash\"\n",
                            "user_defined_fields": {
                                "label": "Enter the DB password",
                                "name": "DB_PASSWORD",
                                "example": "hunter2"
                            }
                        }
            JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/linode/stackscripts', $request, new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $entity = $repository->create([
            StackScript::FIELD_LABEL       => 'a-stackscript',
            StackScript::FIELD_DESCRIPTION => "This StackScript installs and configures MySQL\n",
            StackScript::FIELD_IMAGES      => [
                'linode/debian9',
                'linode/debian8',
            ],
            StackScript::FIELD_IS_PUBLIC   => true,
            StackScript::FIELD_REV_NOTE    => 'Set up MySQL',
            StackScript::FIELD_SCRIPT      => "\"#!/bin/bash\"\n",
        ]);

        self::assertInstanceOf(StackScript::class, $entity);
        self::assertSame(10079, $entity->id);
        self::assertSame('a-stackscript', $entity->label);
    }

    public function testUpdate(): void
    {
        $request = [
            'json' => [
                'label'       => 'a-stackscript',
                'description' => "This StackScript installs and configures MySQL\n",
                'images'      => [
                    'linode/debian9',
                    'linode/debian8',
                ],
                'is_public'   => true,
                'rev_note'    => 'Set up MySQL',
                'script'      => "\"#!/bin/bash\"\n",
            ],
        ];

        $response = <<<'JSON'
                        {
                            "id": 10079,
                            "username": "myuser",
                            "user_gravatar_id": "a445b305abda30ebc766bc7fda037c37",
                            "label": "a-stackscript",
                            "description": "This StackScript installs and configures MySQL\n",
                            "images": [
                                "linode/debian9",
                                "linode/debian8"
                            ],
                            "deployments_total": 12,
                            "deployments_active": 1,
                            "is_public": true,
                            "created": "2018-01-01T00:01:01",
                            "updated": "2018-01-01T00:01:01",
                            "rev_note": "Set up MySQL",
                            "script": "\"#!/bin/bash\"\n",
                            "user_defined_fields": {
                                "label": "Enter the DB password",
                                "name": "DB_PASSWORD",
                                "example": "hunter2"
                            }
                        }
            JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['PUT', 'https://api.linode.com/v4/linode/stackscripts/10079', $request, new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $entity = $repository->update(10079, [
            StackScript::FIELD_LABEL       => 'a-stackscript',
            StackScript::FIELD_DESCRIPTION => "This StackScript installs and configures MySQL\n",
            StackScript::FIELD_IMAGES      => [
                'linode/debian9',
                'linode/debian8',
            ],
            StackScript::FIELD_IS_PUBLIC   => true,
            StackScript::FIELD_REV_NOTE    => 'Set up MySQL',
            StackScript::FIELD_SCRIPT      => "\"#!/bin/bash\"\n",
        ]);

        self::assertInstanceOf(StackScript::class, $entity);
        self::assertSame(10079, $entity->id);
        self::assertSame('a-stackscript', $entity->label);
    }

    public function testDelete(): void
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['DELETE', 'https://api.linode.com/v4/linode/stackscripts/10079', [], new Response(200, [], null)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $repository->delete(10079);

        self::assertTrue(true);
    }

    public function testGetBaseUri(): void
    {
        $expected = '/linode/stackscripts';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields(): void
    {
        $expected = [
            'id',
            'username',
            'label',
            'images',
            'is_public',
            'created',
            'updated',
            'user_gravatar_id',
            'description',
            'deployments_total',
            'deployments_active',
            'rev_note',
            'script',
            'user_defined_fields',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity(): void
    {
        self::assertInstanceOf(StackScript::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): StackScriptRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new StackScriptRepository($linodeClient);
    }
}
