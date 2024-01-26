<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\LinodeTypes;

use Linode\RepositoryInterface;

/**
 * LinodeType repository.
 *
 * @method LinodeType   find(int|string $id)
 * @method LinodeType[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method LinodeType[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method LinodeType   findOneBy(array $criteria)
 * @method LinodeType[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface LinodeTypeRepositoryInterface extends RepositoryInterface {}
