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

use Linode\Entity\Account\Invoice;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Account\InvoiceRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\Account\InvoiceRepository
 */
final class InvoiceRepositoryTest extends TestCase
{
    use ReflectionTrait;

    protected InvoiceRepositoryInterface $repository;

    protected function setUp(): void
    {
        $client = new LinodeClient();

        $this->repository = new InvoiceRepository($client);
    }

    public function testGetBaseUri(): void
    {
        $expected = '/account/invoices';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields(): void
    {
        $expected = [
            'id',
            'date',
            'label',
            'subtotal',
            'tax',
            'total',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity(): void
    {
        self::assertInstanceOf(Invoice::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }
}
