<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\LKE;

use Linode\RepositoryInterface;

/**
 * LKEVersion repository.
 *
 * @method LKEVersion   find(int|string $id)
 * @method LKEVersion[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method LKEVersion[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method LKEVersion   findOneBy(array $criteria)
 * @method LKEVersion[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface LKEVersionRepositoryInterface extends RepositoryInterface {}
