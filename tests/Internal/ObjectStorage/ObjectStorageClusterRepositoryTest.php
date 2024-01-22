<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal\ObjectStorage;

use Linode\Entity\ObjectStorage\ObjectStorageCluster;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\ObjectStorage\ObjectStorageClusterRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\ObjectStorage\ObjectStorageClusterRepository
 */
final class ObjectStorageClusterRepositoryTest extends TestCase
{
    use ReflectionTrait;

    protected ObjectStorageClusterRepositoryInterface $repository;

    protected function setUp(): void
    {
        $client = new LinodeClient();

        $this->repository = new ObjectStorageClusterRepository($client);
    }

    public function testGetBaseUri(): void
    {
        $expected = 'beta/object-storage/clusters';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields(): void
    {
        $expected = [
            'id',
            'domain',
            'status',
            'region',
            'static_site_domain',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity(): void
    {
        self::assertInstanceOf(ObjectStorageCluster::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }
}
