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
 * DatabaseEngine repository.
 *
 * @method DatabaseEngine   find(int|string $id)
 * @method DatabaseEngine[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method DatabaseEngine[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method DatabaseEngine   findOneBy(array $criteria)
 * @method DatabaseEngine[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface DatabaseEngineRepositoryInterface extends RepositoryInterface {}
