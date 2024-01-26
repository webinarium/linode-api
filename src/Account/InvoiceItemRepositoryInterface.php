<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Account;

use Linode\RepositoryInterface;

/**
 * InvoiceItem repository.
 *
 * @method InvoiceItem   find(int|string $id)
 * @method InvoiceItem[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method InvoiceItem[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method InvoiceItem   findOneBy(array $criteria)
 * @method InvoiceItem[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface InvoiceItemRepositoryInterface extends RepositoryInterface {}
