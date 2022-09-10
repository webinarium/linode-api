<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity;

use Linode\LinodeClient;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Entity\StackScript
 */
final class StackScriptTest extends TestCase
{
    protected LinodeClient $client;

    protected function setUp(): void
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties(): void
    {
        $data = [
            'id'                  => 10079,
            'username'            => 'myuser',
            'user_gravatar_id'    => 'a445b305abda30ebc766bc7fda037c37',
            'label'               => 'a-stackscript',
            'description'         => "This StackScript installs and configures MySQL\n",
            'images'              => [
                'linode/debian9',
                'linode/debian8',
            ],
            'deployments_total'   => 12,
            'deployments_active'  => 1,
            'is_public'           => true,
            'created'             => '2018-01-01T00=>01=>01',
            'updated'             => '2018-01-01T00=>01=>01',
            'rev_note'            => 'Set up MySQL',
            'script'              => "\"#!/bin/bash\"\n",
            'user_defined_fields' => [
                [
                    'label'   => 'Enter the DB password',
                    'name'    => 'DB_PASSWORD',
                    'example' => 'hunter2',
                ],
            ],
        ];

        $entity = new StackScript($this->client, $data);

        self::assertCount(1, $entity->user_defined_fields);
        self::assertInstanceOf(UserDefinedField::class, $entity->user_defined_fields[0]);
        self::assertSame('Enter the DB password', $entity->user_defined_fields[0]->label);

        self::assertSame(10079, $entity->id);
    }
}
