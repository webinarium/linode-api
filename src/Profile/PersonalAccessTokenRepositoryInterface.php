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
 * PersonalAccessToken repository.
 *
 * @method PersonalAccessToken   find(int|string $id)
 * @method PersonalAccessToken[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method PersonalAccessToken[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method PersonalAccessToken   findOneBy(array $criteria)
 * @method PersonalAccessToken[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface PersonalAccessTokenRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a Personal Access Token for your User. The raw token will be returned in
     * the response, but will never be returned again afterward so be sure to take note
     * of it. You may create a token with _at most_ the scopes of your current token. The
     * created token will be able to access your Account until the given expiry, or until
     * it is revoked.
     *
     * @param array $parameters Information about the requested token.
     *
     * @throws LinodeException
     */
    public function createPersonalAccessToken(array $parameters = []): PersonalAccessToken;

    /**
     * Updates a Personal Access Token.
     *
     * @param int   $tokenId    The ID of the token to access.
     * @param array $parameters The fields to update.
     *
     * @throws LinodeException
     */
    public function updatePersonalAccessToken(int $tokenId, array $parameters = []): PersonalAccessToken;

    /**
     * Revokes a Personal Access Token. The token will be invalidated immediately, and
     * requests using that token will fail with a 401. It is possible to revoke access to
     * the token making the request to revoke a token, but keep in mind that doing so
     * could lose you access to the api and require you to create a new token through
     * some other means.
     *
     * @param int $tokenId The ID of the token to access.
     *
     * @throws LinodeException
     */
    public function deletePersonalAccessToken(int $tokenId): void;
}
