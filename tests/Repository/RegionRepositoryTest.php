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

use Linode\Entity\Region;
use Linode\ReflectionTrait;
use PHPUnit\Framework\TestCase;

class RegionRepositoryTest extends TestCase
{
    use ReflectionTrait;

    /** @var RegionRepository */
    protected $repository;

    protected function setUp()
    {
        $this->repository = new RegionRepository();
    }

    public function testConstructor()
    {
        $expected = 'https://api.linode.com/v4/regions';

        self::assertSame($expected, $this->getProperty($this->repository, 'base_uri'));
    }

    public function testGetSupportedFields()
    {
        $expected = [
            'id',
            'country',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity()
    {
        self::assertInstanceOf(Region::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }
}
