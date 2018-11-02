<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal\Managed;

use Linode\Entity\Managed\ManagedIssue;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use PHPUnit\Framework\TestCase;

class ManagedIssueRepositoryTest extends TestCase
{
    use ReflectionTrait;

    /** @var ManagedIssueRepository */
    protected $repository;

    protected function setUp()
    {
        $client = new LinodeClient();

        $this->repository = new ManagedIssueRepository($client);
    }

    public function testGetBaseUri()
    {
        $expected = '/managed/issues';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields()
    {
        $expected = [];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity()
    {
        self::assertInstanceOf(ManagedIssue::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }
}
