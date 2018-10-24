<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal;

use Linode\Entity\LinodeType;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use PHPUnit\Framework\TestCase;

class LinodeTypeRepositoryTest extends TestCase
{
    use ReflectionTrait;

    /** @var LinodeTypeRepository */
    protected $repository;

    protected function setUp()
    {
        $client = new LinodeClient();

        $this->repository = new LinodeTypeRepository($client);
    }

    public function testGetBaseUri()
    {
        $expected = '/linode/types';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
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
