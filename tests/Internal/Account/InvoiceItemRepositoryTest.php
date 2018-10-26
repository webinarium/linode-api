<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal\Account;

use Linode\Entity\Account\InvoiceItem;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use PHPUnit\Framework\TestCase;

class InvoiceItemRepositoryTest extends TestCase
{
    use ReflectionTrait;

    /** @var InvoiceItemRepository */
    protected $repository;

    protected function setUp()
    {
        $client = new LinodeClient();

        $this->repository = new InvoiceItemRepository($client, 123);
    }

    public function testGetBaseUri()
    {
        $expected = '/account/invoices/123/items';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields()
    {
        $expected = [
            'label',
            'from',
            'to',
            'amount',
            'quantity',
            'unitprice',
            'type',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity()
    {
        self::assertInstanceOf(InvoiceItem::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }
}
