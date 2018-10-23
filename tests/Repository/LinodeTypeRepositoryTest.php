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

use Linode\Entity\LinodeType;
use Linode\ReflectionTrait;
use PHPUnit\Framework\TestCase;

class LinodeTypeRepositoryTest extends TestCase
{
    use ReflectionTrait;

    /** @var LinodeTypeRepository */
    protected $repository;

    protected function setUp()
    {
        $this->repository = new LinodeTypeRepository();
    }

    public function testConstructor()
    {
        $expected = 'https://api.linode.com/v4/linode/types';

        self::assertSame($expected, $this->getProperty($this->repository, 'base_uri'));
    }

    public function testGetSupportedFields()
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

    public function testJsonToEntity()
    {
        self::assertInstanceOf(LinodeType::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }
}
