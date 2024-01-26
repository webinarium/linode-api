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
 * Invoice repository.
 *
 * @method Invoice   find(int|string $id)
 * @method Invoice[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Invoice[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Invoice   findOneBy(array $criteria)
 * @method Invoice[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface InvoiceRepositoryInterface extends RepositoryInterface {}
