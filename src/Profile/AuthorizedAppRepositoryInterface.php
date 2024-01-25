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
 * Authorized application repository.
 */
interface AuthorizedAppRepositoryInterface extends RepositoryInterface
{
    /**
     * @throws LinodeException
     */
    public function revoke(int $id): void;
}
