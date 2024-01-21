<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity\Longview;

use Linode\LinodeClient;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Entity\Longview\LongviewClient
 */
final class LongviewClientTest extends TestCase
{
    protected LinodeClient $client;

    protected function setUp(): void
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties(): void
    {
        $data = [
            'id'           => 789,
            'label'        => 'client789',
            'api_key'      => 'BD1B4B54-D752-A76D-5A9BD8A17F39DB61',
            'install_code' => 'BD1B5605-BF5E-D385-BA07AD518BE7F321',
            'apps'         => [
                'apache' => true,
                'nginx'  => false,
                'mysql'  => true,
            ],
            'created'      => '2018-01-01T00:01:01.000Z',
            'updated'      => '2018-01-01T00:01:01.000Z',
        ];

        $entity = new LongviewClient($this->client, $data);

        self::assertInstanceOf(LongviewApps::class, $entity->apps);
        self::assertSame('client789', $entity->label);
    }
}
