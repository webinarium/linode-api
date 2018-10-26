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

use Linode\Entity\Account\Invoice;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use PHPUnit\Framework\TestCase;

class InvoiceRepositoryTest extends TestCase
{
    use ReflectionTrait;

    /** @var InvoiceRepository */
    protected $repository;

    protected function setUp()
    {
        $client = new LinodeClient();

        $this->repository = new InvoiceRepository($client);
    }

    public function testGetBaseUri()
    {
        $expected = '/account/invoices';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields()
    {
        $expected = [
            'id',
            'date',
            'label',
            'total',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity()
    {
        self::assertInstanceOf(Invoice::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }
}
