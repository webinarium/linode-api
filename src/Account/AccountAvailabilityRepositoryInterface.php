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
 * AccountAvailability repository.
 *
 * @method AccountAvailability   find(int|string $id)
 * @method AccountAvailability[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method AccountAvailability[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method AccountAvailability   findOneBy(array $criteria)
 * @method AccountAvailability[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface AccountAvailabilityRepositoryInterface extends RepositoryInterface {}
