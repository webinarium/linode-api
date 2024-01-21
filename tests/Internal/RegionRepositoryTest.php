<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal;

use Linode\Entity\Region;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\RegionRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\RegionRepository
 */
final class RegionRepositoryTest extends TestCase
{
    use ReflectionTrait;

    protected RegionRepositoryInterface $repository;

    protected function setUp(): void
    {
        $client = new LinodeClient();

        $this->repository = new RegionRepository($client);
    }

    public function testGetBaseUri(): void
    {
        $expected = '/regions';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields(): void
    {
        $expected = [
            'id',
            'country',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity(): void
    {
        self::assertInstanceOf(Region::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }
}
