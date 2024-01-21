<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Repository\Profile;

use Linode\Entity\Profile\PersonalAccessToken;
use Linode\Repository\RepositoryInterface;

/**
 * Personal access token repository.
 */
interface PersonalAccessTokenRepositoryInterface extends RepositoryInterface
{
    /**
     * @throws \Linode\Exception\LinodeException
     */
    public function create(array $parameters): PersonalAccessToken;

    /**
     * @throws \Linode\Exception\LinodeException
     */
    public function update(int $id, array $parameters): PersonalAccessToken;

    /**
     * @throws \Linode\Exception\LinodeException
     */
    public function revoke(int $id): void;
}
