<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity\Managed;

use Linode\LinodeClient;
use PHPUnit\Framework\TestCase;

class ManagedLinodeSettingsTest extends TestCase
{
    protected $client;

    protected function setUp()
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties()
    {
        $data = [
            'id'    => 123,
            'label' => 'linode123',
            'group' => 'linodes',
            'ssh'   => [
                'access' => true,
                'user'   => 'linode',
                'ip'     => '12.34.56.78',
                'port'   => 22,
            ],
        ];

        $entity = new ManagedLinodeSettings($this->client, $data);

        self::assertInstanceOf(SSHSettings::class, $entity->ssh);
        self::assertSame('linode123', $entity->label);
    }
}
