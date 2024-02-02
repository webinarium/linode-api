<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Databases;

use Linode\RepositoryInterface;

/**
 * DatabaseType repository.
 *
 * @method DatabaseType   find(int|string $id)
 * @method DatabaseType[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method DatabaseType[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method DatabaseType   findOneBy(array $criteria)
 * @method DatabaseType[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface DatabaseTypeRepositoryInterface extends RepositoryInterface {}
