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
 * OAuthClient repository.
 *
 * @method OAuthClient   find(int|string $id)
 * @method OAuthClient[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method OAuthClient[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method OAuthClient   findOneBy(array $criteria)
 * @method OAuthClient[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface OAuthClientRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates an OAuth Client, which can be used to allow users (using their Linode
     * account) to log in to your own application, and optionally grant your application
     * some amount of access to their Linodes or other entities.
     *
     * @param array $parameters Information about the OAuth Client to create.
     *
     * @throws LinodeException
     */
    public function createClient(array $parameters = []): OAuthClient;

    /**
     * Update information about an OAuth Client on your Account. This can be especially
     * useful to update the `redirect_uri` of your client in the event that the callback
     * url changed in your application.
     *
     * @param string $clientId   The OAuth Client ID to look up.
     * @param array  $parameters The fields to update.
     *
     * @throws LinodeException
     */
    public function updateClient(string $clientId, array $parameters = []): OAuthClient;

    /**
     * Deletes an OAuth Client registered with Linode. The Client ID and Client secret
     * will no longer be accepted by https://login.linode.com, and all tokens issued to
     * this client will be invalidated (meaning that if your application was using a
     * token, it will no longer work).
     *
     * @param string $clientId The OAuth Client ID to look up.
     *
     * @throws LinodeException
     */
    public function deleteClient(string $clientId): void;

    /**
     * Resets the OAuth Client secret for a client you own, and returns the OAuth Client
     * with the plaintext secret. This secret is not supposed to be publicly known or
     * disclosed anywhere. This can be used to generate a new secret in case the one you
     * have has been leaked, or to get a new secret if you lost the original. The old
     * secret is expired immediately, and logins to your client with the old secret will
     * fail.
     *
     * @param string $clientId The OAuth Client ID to look up.
     *
     * @throws LinodeException
     */
    public function resetClientSecret(string $clientId): OAuthClient;

    /**
     * Returns the thumbnail for this OAuth Client. This is a publicly-viewable endpoint,
     * and can be accessed without authentication.
     *
     * @param string $clientId The OAuth Client ID to look up.
     *
     * @return string The client's thumbnail (binary data).
     *
     * @throws LinodeException
     */
    public function getClientThumbnail(string $clientId): string;

    /**
     * Upload a thumbnail for a client you own. You must upload an image file that will
     * be returned when the thumbnail is retrieved. This image will be publicly-viewable.
     *
     * @param string $clientId The OAuth Client ID to look up.
     * @param string $file     The local, absolute path to the file with the image to set as the thumbnail.
     *
     * @throws LinodeException
     */
    public function setClientThumbnail(string $clientId, string $file): void;
}
