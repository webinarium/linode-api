<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Networking;

use Linode\RepositoryInterface;

/**
 * IPv6Range repository.
 *
 * @method IPv6Range   find(int|string $id)
 * @method IPv6Range[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method IPv6Range[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method IPv6Range   findOneBy(array $criteria)
 * @method IPv6Range[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface IPv6RangeRepositoryInterface extends RepositoryInterface {}
