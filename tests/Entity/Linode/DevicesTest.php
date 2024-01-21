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
 * @coversDefaultClass \Linode\Entity\Linode\Devices
 */
final class DevicesTest extends TestCase
{
    protected LinodeClient $client;

    protected function setUp(): void
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties(): void
    {
        $entity = new Devices($this->client, [
            'sda' => [
                'disk_id'   => 124458,
                'volume_id' => null,
            ],
            'sdb' => [
                'disk_id'   => 124458,
                'volume_id' => null,
            ],
            'sdc' => [
                'disk_id'   => 124458,
                'volume_id' => null,
            ],
            'sdd' => [
                'disk_id'   => 124458,
                'volume_id' => null,
            ],
            'sde' => [
                'disk_id'   => 124458,
                'volume_id' => null,
            ],
            'sdf' => [
                'disk_id'   => 124458,
                'volume_id' => null,
            ],
            'sdg' => [
                'disk_id'   => 124458,
                'volume_id' => null,
            ],
            'sdh' => [
                'disk_id'   => 124458,
                'volume_id' => null,
            ],
        ]);

        self::assertInstanceOf(Device::class, $entity->sda);
        self::assertSame(124458, $entity->sda->disk_id);
        self::assertNull($entity->sda->volume_id);

        self::assertInstanceOf(Device::class, $entity->sdb);
        self::assertSame(124458, $entity->sdb->disk_id);
        self::assertNull($entity->sdb->volume_id);

        self::assertInstanceOf(Device::class, $entity->sdc);
        self::assertSame(124458, $entity->sdc->disk_id);
        self::assertNull($entity->sdc->volume_id);

        self::assertInstanceOf(Device::class, $entity->sdd);
        self::assertSame(124458, $entity->sdd->disk_id);
        self::assertNull($entity->sdd->volume_id);

        self::assertInstanceOf(Device::class, $entity->sde);
        self::assertSame(124458, $entity->sde->disk_id);
        self::assertNull($entity->sde->volume_id);

        self::assertInstanceOf(Device::class, $entity->sdf);
        self::assertSame(124458, $entity->sdf->disk_id);
        self::assertNull($entity->sdf->volume_id);

        self::assertInstanceOf(Device::class, $entity->sdg);
        self::assertSame(124458, $entity->sdg->disk_id);
        self::assertNull($entity->sdg->volume_id);

        self::assertInstanceOf(Device::class, $entity->sdh);
        self::assertSame(124458, $entity->sdh->disk_id);
        self::assertNull($entity->sdh->volume_id);

        self::assertNull($entity->unknown);
    }
}
