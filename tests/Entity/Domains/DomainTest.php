<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity\Domains;

use Linode\Internal\Domains\DomainRecordRepository;
use Linode\LinodeClient;
use PHPUnit\Framework\TestCase;

class DomainTest extends TestCase
{
    protected $client;

    protected function setUp()
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testRecords()
    {
        $entity = new Domain($this->client, ['id' => 123]);

        self::assertInstanceOf(DomainRecordRepository::class, $entity->records);
    }
}
