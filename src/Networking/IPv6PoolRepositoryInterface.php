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
 * IPv6Pool repository.
 *
 * @method IPv6Pool   find(int|string $id)
 * @method IPv6Pool[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method IPv6Pool[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method IPv6Pool   findOneBy(array $criteria)
 * @method IPv6Pool[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface IPv6PoolRepositoryInterface extends RepositoryInterface {}
