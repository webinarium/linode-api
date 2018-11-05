<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal\Linode;

use Linode\Entity\Volume;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use PHPUnit\Framework\TestCase;

class LinodeVolumeRepositoryTest extends TestCase
{
    use ReflectionTrait;

    /** @var LinodeVolumeRepository */
    protected $repository;

    protected function setUp()
    {
        $client = new LinodeClient();

        $this->repository = new LinodeVolumeRepository($client, 123);
    }

    public function testGetBaseUri()
    {
        $expected = '/linode/instances/123/volumes';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields()
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

    public function testJsonToEntity()
    {
        self::assertInstanceOf(Volume::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }
}
