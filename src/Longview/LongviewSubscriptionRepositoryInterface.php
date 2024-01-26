<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Longview;

use Linode\RepositoryInterface;

/**
 * LongviewSubscription repository.
 *
 * @method LongviewSubscription   find(int|string $id)
 * @method LongviewSubscription[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method LongviewSubscription[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method LongviewSubscription   findOneBy(array $criteria)
 * @method LongviewSubscription[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface LongviewSubscriptionRepositoryInterface extends RepositoryInterface {}
