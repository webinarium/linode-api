<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\LinodeInstances;

use Linode\RepositoryInterface;

/**
 * Kernel repository.
 *
 * @method Kernel   find(int|string $id)
 * @method Kernel[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Kernel[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Kernel   findOneBy(array $criteria)
 * @method Kernel[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface KernelRepositoryInterface extends RepositoryInterface {}
