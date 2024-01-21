<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal\Account;

use Linode\Entity\Account\InvoiceItem;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Account\InvoiceItemRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\Account\InvoiceItemRepository
 */
final class InvoiceItemRepositoryTest extends TestCase
{
    use ReflectionTrait;

    protected InvoiceItemRepositoryInterface $repository;

    protected function setUp(): void
    {
        $client = new LinodeClient();

        $this->repository = new InvoiceItemRepository($client, 123);
    }

    public function testGetBaseUri(): void
    {
        $expected = '/account/invoices/123/items';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields(): void
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

    public function testJsonToEntity(): void
    {
        self::assertInstanceOf(InvoiceItem::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }
}
