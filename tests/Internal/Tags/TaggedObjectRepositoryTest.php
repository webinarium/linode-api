<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal\Tags;

use Linode\Entity\Linode;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use PHPUnit\Framework\TestCase;

class TaggedObjectRepositoryTest extends TestCase
{
    use ReflectionTrait;

    /** @var TaggedObjectRepository */
    protected $repository;

    protected function setUp()
    {
        $client = new LinodeClient();

        $this->repository = new TaggedObjectRepository($client, 'example tag');
    }

    public function testGetBaseUri()
    {
        $expected = '/tags/example tag';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields()
    {
        $expected = [
            'id',
            'label',
            'region',
            'image',
            'type',
            'status',
            'hypervisor',
            'watchdog_enabled',
            'created',
            'updated',
            'group',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity()
    {
        self::assertInstanceOf(Linode::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }
}
