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
 * Database repository.
 *
 * @method Database   find(int|string $id)
 * @method Database[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Database[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Database   findOneBy(array $criteria)
 * @method Database[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface DatabaseRepositoryInterface extends RepositoryInterface {}
