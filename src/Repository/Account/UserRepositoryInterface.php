<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Repository\Account;

use Linode\Entity\Account\User;
use Linode\Entity\Account\UserGrant;
use Linode\Exception\LinodeException;
use Linode\Repository\RepositoryInterface;

/**
 * User repository.
 */
interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a User on your Account. Once created, the User will be
     * able to log in and access portions of your Account. Access is
     * determined by whether or not they are restricted, and what grants they
     * have been given.
     *
     * @throws LinodeException
     */
    public function create(array $parameters): User;

    /**
     * Update information about a User on your Account. This can be used to
     * change the restricted status of a User. When making a User restricted,
     * no grants will be configured by default and you must then set up grants
     * in order for the User to access anything on the Account.
     *
     * @throws LinodeException
     */
    public function update(string $username, array $parameters): User;

    /**
     * Deletes a User. The deleted User will be immediately logged out and
     * may no longer log in or perform any actions. All of the User's Grants
     * will be removed.
     *
     * @throws LinodeException
     */
    public function delete(string $username): void;

    /**
     * Returns the full grants structure for this User. This includes all
     * entities on the Account alongside what level of access this User has
     * to each of them. Individual users may view their own grants at the
     * `/profile/grants` endpoint, but will not see entities that they have
     * no access to.
     *
     * @return null|UserGrant Returns `null` when this is an unrestricted User,
     *                        and therefore has no grants to return. This User
     *                        may access everything on the Account and perform
     *                        all actions.
     *
     * @throws LinodeException
     */
    public function getUserGrants(string $username): ?UserGrant;

    /**
     * Update the grants a User has. This can be used to give a User access
     * to new entities or actions, or take access away. You do not need to
     * include the grant for every entity on the Account in this request; any
     * that are not included will remain unchanged.
     *
     * @throws LinodeException
     */
    public function setUserGrants(string $username, array $parameters): UserGrant;
}
