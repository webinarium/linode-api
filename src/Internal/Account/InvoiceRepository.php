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
use Linode\Entity\Entity;
use Linode\Internal\AbstractRepository;
use Linode\Repository\Account\InvoiceRepositoryInterface;

class InvoiceRepository extends AbstractRepository implements InvoiceRepositoryInterface
{
    protected function getBaseUri(): string
    {
        return '/account/invoices';
    }

    protected function getSupportedFields(): array
    {
        return [
            Invoice::FIELD_ID,
            Invoice::FIELD_DATE,
            Invoice::FIELD_LABEL,
            Invoice::FIELD_SUBTOTAL,
            Invoice::FIELD_TAXL,
            Invoice::FIELD_TOTAL,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new Invoice($this->client, $json);
    }
}
