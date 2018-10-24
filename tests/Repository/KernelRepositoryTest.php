<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Repository;

use Linode\Entity\Kernel;
use Linode\ReflectionTrait;
use PHPUnit\Framework\TestCase;

class KernelRepositoryTest extends TestCase
{
    use ReflectionTrait;

    /** @var KernelRepository */
    protected $repository;

    protected function setUp()
    {
        $this->repository = new KernelRepository();
    }

    public function testConstructor()
    {
        $expected = 'https://api.linode.com/v4/linode/kernels';

        self::assertSame($expected, $this->getProperty($this->repository, 'base_uri'));
    }

    public function testGetSupportedFields()
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

    public function testJsonToEntity()
    {
        self::assertInstanceOf(Kernel::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }
}
