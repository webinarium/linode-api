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

use Linode\Entity\LinodeType;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\LinodeTypeRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\LinodeTypeRepository
 */
final class LinodeTypeRepositoryTest extends TestCase
{
    use ReflectionTrait;

    protected LinodeTypeRepositoryInterface $repository;

    protected function setUp(): void
    {
        $client = new LinodeClient();

        $this->repository = new LinodeTypeRepository($client);
    }

    public function testGetBaseUri(): void
    {
        $expected = '/linode/types';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields(): void
    {
        $expected = [
            'id',
            'label',
            'class',
            'disk',
            'memory',
            'vcpus',
            'network_out',
            'transfer',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity(): void
    {
        self::assertInstanceOf(LinodeType::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }
}
