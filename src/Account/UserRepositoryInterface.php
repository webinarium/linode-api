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
 * User repository.
 *
 * @method User   find(int|string $id)
 * @method User[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method User[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method User   findOneBy(array $criteria)
 * @method User[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a User on your Account. Once created, the User will be able to log in and
     * access portions of your Account. Access is determined by whether or not they are
     * restricted, and what grants they have been given.
     *
     * @param array $parameters Information about the User to create.
     *
     * @throws LinodeException
     */
    public function createUser(array $parameters = []): User;

    /**
     * Update information about a User on your Account. This can be used to change the
     * restricted status of a User. When making a User restricted, no grants will be
     * configured by default and you must then set up grants in order for the User to
     * access anything on the Account.
     *
     * @param string $username   The username to look up.
     * @param array  $parameters The information to update.
     *
     * @throws LinodeException
     */
    public function updateUser(string $username, array $parameters = []): User;

    /**
     * Deletes a User. The deleted User will be immediately logged out and may no longer
     * log in or perform any actions. All of the User's Grants will be removed.
     *
     * @param string $username The username to look up.
     *
     * @throws LinodeException
     */
    public function deleteUser(string $username): void;

    /**
     * Returns the full grants structure for the specified account User (other than the
     * account owner, see below for details). This includes all entities on the Account
     * alongside the level of access this User has to each of them.
     *
     * The current authenticated User, including the account owner, may view their own
     * grants at the /profile/grants endpoint, but will not see entities that they do not
     * have access to.
     *
     * @param string $username The username to look up.
     *
     * @return null|GrantsResponse When `null` is returned, this is an unrestricted User. This User may access
     *                             everything on the Account and perform all actions.
     *
     * @throws LinodeException
     */
    public function getUserGrants(string $username): ?GrantsResponse;

    /**
     * Update the grants a User has. This can be used to give a User access to new
     * entities or actions, or take access away. You do not need to include the grant for
     * every entity on the Account in this request; any that are not included will remain
     * unchanged.
     *
     * @param string $username   The username to look up.
     * @param array  $parameters The grants to update. Omitted grants will be left unchanged.
     *
     * @throws LinodeException
     */
    public function updateUserGrants(string $username, array $parameters = []): GrantsResponse;
}
