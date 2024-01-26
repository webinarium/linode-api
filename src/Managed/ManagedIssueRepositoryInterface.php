<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Managed;

use Linode\RepositoryInterface;

/**
 * ManagedIssue repository.
 *
 * @method ManagedIssue   find(int|string $id)
 * @method ManagedIssue[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method ManagedIssue[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method ManagedIssue   findOneBy(array $criteria)
 * @method ManagedIssue[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface ManagedIssueRepositoryInterface extends RepositoryInterface {}
