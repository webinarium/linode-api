<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Regions;

use Linode\RepositoryInterface;

/**
 * Region repository.
 *
 * @method Region   find(int|string $id)
 * @method Region[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Region[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Region   findOneBy(array $criteria)
 * @method Region[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface RegionRepositoryInterface extends RepositoryInterface {}
