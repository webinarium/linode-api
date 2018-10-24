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
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use PHPUnit\Framework\TestCase;

class RegionRepositoryTest extends TestCase
{
    use ReflectionTrait;

    /** @var RegionRepository */
    protected $repository;

    protected function setUp()
    {
        $client = new LinodeClient();

        $this->repository = new RegionRepository($client);
    }

    public function testBaseApiUri()
    {
        $expected = '/regions';

        self::assertSame($expected, $this->getConstant($this->repository, 'BASE_API_URI'));
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
