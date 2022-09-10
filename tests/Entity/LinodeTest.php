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

use Linode\Internal\Linode\ConfigurationProfileRepository;
use Linode\Internal\Linode\DiskRepository;
use Linode\Internal\Linode\LinodeNetworkRepository;
use Linode\Internal\Linode\LinodeVolumeRepository;
use Linode\LinodeClient;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Entity\Linode
 */
final class LinodeTest extends TestCase
{
    protected LinodeClient $client;

    protected function setUp(): void
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties(): void
    {
        $entity = new Linode($this->client, ['id' => 123]);

        self::assertInstanceOf(ConfigurationProfileRepository::class, $entity->configs);
        self::assertInstanceOf(DiskRepository::class, $entity->disks);
        self::assertInstanceOf(LinodeNetworkRepository::class, $entity->ips);
        self::assertInstanceOf(LinodeVolumeRepository::class, $entity->volumes);
    }
}
