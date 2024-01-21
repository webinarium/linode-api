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

use Linode\Entity\Kernel;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\KernelRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\KernelRepository
 */
final class KernelRepositoryTest extends TestCase
{
    use ReflectionTrait;

    protected KernelRepositoryInterface $repository;

    protected function setUp(): void
    {
        $client = new LinodeClient();

        $this->repository = new KernelRepository($client);
    }

    public function testGetBaseUri(): void
    {
        $expected = '/linode/kernels';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields(): void
    {
        $expected = [
            'id',
            'label',
            'version',
            'architecture',
            'kvm',
            'xen',
            'pvops',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity(): void
    {
        self::assertInstanceOf(Kernel::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }
}
