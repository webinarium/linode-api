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
 * Personal access token repository.
 */
interface PersonalAccessTokenRepositoryInterface extends RepositoryInterface
{
    /**
     * @throws LinodeException
     */
    public function create(array $parameters): PersonalAccessToken;

    /**
     * @throws LinodeException
     */
    public function update(int $id, array $parameters): PersonalAccessToken;

    /**
     * @throws LinodeException
     */
    public function revoke(int $id): void;
}
