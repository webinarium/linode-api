<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\ObjectStorage;

use Linode\RepositoryInterface;

/**
 * ObjectStorageCluster repository.
 *
 * @method ObjectStorageCluster   find(int|string $id)
 * @method ObjectStorageCluster[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method ObjectStorageCluster[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method ObjectStorageCluster   findOneBy(array $criteria)
 * @method ObjectStorageCluster[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface ObjectStorageClusterRepositoryInterface extends RepositoryInterface {}
