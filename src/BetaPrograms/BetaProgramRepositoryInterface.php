<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\BetaPrograms;

use Linode\RepositoryInterface;

/**
 * BetaProgram repository.
 *
 * @method BetaProgram   find(int|string $id)
 * @method BetaProgram[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method BetaProgram[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method BetaProgram   findOneBy(array $criteria)
 * @method BetaProgram[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface BetaProgramRepositoryInterface extends RepositoryInterface {}
