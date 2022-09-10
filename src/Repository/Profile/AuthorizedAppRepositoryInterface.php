<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Repository\Profile;

use Linode\Repository\RepositoryInterface;

/**
 * Authorized application repository.
 */
interface AuthorizedAppRepositoryInterface extends RepositoryInterface
{
    /**
     * @throws \Linode\Exception\LinodeException
     */
    public function revoke(int $id): void;
}
