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

use Linode\Entity\Profile\PersonalAccessToken;
use Linode\Repository\RepositoryInterface;

/**
 * Personal access token repository.
 */
interface PersonalAccessTokenRepositoryInterface extends RepositoryInterface
{
    /**
     * @param array $parameters
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return PersonalAccessToken
     */
    public function create(array $parameters): PersonalAccessToken;

    /**
     * @param int   $id
     * @param array $parameters
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return PersonalAccessToken
     */
    public function update(int $id, array $parameters): PersonalAccessToken;

    /**
     * @param int $id
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function revoke(int $id): void;
}
