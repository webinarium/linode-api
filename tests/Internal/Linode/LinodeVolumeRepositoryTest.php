<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal\Linode;

use Linode\Entity\Volume;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Linode\LinodeVolumeRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\Linode\LinodeVolumeRepository
 */
final class LinodeVolumeRepositoryTest extends TestCase
{
    use ReflectionTrait;

    protected LinodeVolumeRepositoryInterface $repository;

    protected function setUp(): void
    {
        $client = new LinodeClient();

        $this->repository = new LinodeVolumeRepository($client, 123);
    }

    public function testGetBaseUri(): void
    {
        $expected = '/linode/instances/123/volumes';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields(): void
    {
        $expected = [
            'id',
            'label',
            'status',
            'size',
            'region',
            'linode_id',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity(): void
    {
        self::assertInstanceOf(Volume::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }
}
