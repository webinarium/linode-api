<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Account;

use Linode\RepositoryInterface;

/**
 * Notification repository.
 *
 * @method Notification   find(int|string $id)
 * @method Notification[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Notification[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Notification   findOneBy(array $criteria)
 * @method Notification[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface NotificationRepositoryInterface extends RepositoryInterface {}
