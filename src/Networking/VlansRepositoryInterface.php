<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Networking;

use Linode\RepositoryInterface;

/**
 * Vlans repository.
 *
 * @method Vlans   find(int|string $id)
 * @method Vlans[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Vlans[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Vlans   findOneBy(array $criteria)
 * @method Vlans[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface VlansRepositoryInterface extends RepositoryInterface {}
