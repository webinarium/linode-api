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

use Linode\Exception\LinodeException;
use Linode\RepositoryInterface;

/**
 * BetaProgramEnrolled repository.
 *
 * @method BetaProgramEnrolled   find(int|string $id)
 * @method BetaProgramEnrolled[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method BetaProgramEnrolled[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method BetaProgramEnrolled   findOneBy(array $criteria)
 * @method BetaProgramEnrolled[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface BetaProgramEnrolledRepositoryInterface extends RepositoryInterface
{
    /**
     * Enroll your Account in an active Beta Program.
     *
     * Only unrestricted Users can access this command.
     *
     * To view active Beta Programs, use the Beta Programs List command.
     *
     * Active Beta Programs may have a limited number of enrollments. If a Beta Program
     * has reached is maximum number of enrollments, an error is returned even though the
     * request is successful.
     *
     * Beta Programs with `"greenlight_only": true` can only be enrolled by Accounts that
     * participate in the Greenlight program.
     *
     * @param array $parameters Updated information for the Managed MySQL Database.
     *
     * @throws LinodeException
     */
    public function enrollBetaProgram(array $parameters = []): void;
}
