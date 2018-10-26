<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity\Account;

use Linode\Internal\Account\InvoiceItemRepository;
use Linode\LinodeClient;
use PHPUnit\Framework\TestCase;

class InvoiceTest extends TestCase
{
    protected $client;

    protected function setUp()
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties()
    {
        $entity = new Invoice($this->client, ['id' => 123]);

        self::assertInstanceOf(InvoiceItemRepository::class, $entity->items);
    }
}
