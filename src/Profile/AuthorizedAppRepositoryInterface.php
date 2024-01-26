<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Profile;

use Linode\Exception\LinodeException;
use Linode\RepositoryInterface;

/**
 * AuthorizedApp repository.
 *
 * @method AuthorizedApp   find(int|string $id)
 * @method AuthorizedApp[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method AuthorizedApp[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method AuthorizedApp   findOneBy(array $criteria)
 * @method AuthorizedApp[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface AuthorizedAppRepositoryInterface extends RepositoryInterface
{
    /**
     * Expires this app token. This token may no longer be used to access your Account.
     *
     * @param int $appId The authorized app ID to manage.
     *
     * @throws LinodeException
     */
    public function deleteProfileApp(int $appId): void;
}
