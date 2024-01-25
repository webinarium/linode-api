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
 * OAuth client repository.
 */
interface OAuthClientRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates an OAuth Client, which can be used to allow users
     * (using their Linode account) to log in to your own application, and optionally grant
     * your application some amount of access to their Linodes or other entities.
     *
     * @throws LinodeException
     */
    public function create(array $parameters): OAuthClient;

    /**
     * Update information about an OAuth Client on your Account. This can be
     * especially useful to update the `redirect_uri` of your client in the event
     * that the callback url changed in your application.
     *
     * @throws LinodeException
     */
    public function update(string $id, array $parameters): OAuthClient;

    /**
     * Deletes an OAuth Client registered with Linode. The Client ID and
     * Client secret will no longer be accepted by https://login.linode.com,
     * and all tokens issued to this client will be invalidated (meaning that
     * if your application was using a token, it will no longer work).
     *
     * @throws LinodeException
     */
    public function delete(string $id): void;

    /**
     * Resets the OAuth Client secret for a client you own, and returns the
     * OAuth Client with the plaintext secret. This secret is not supposed to
     * be publicly known or disclosed anywhere. This can be used to generate
     * a new secret in case the one you have has been leaked, or to get a new
     * secret if you lost the original. The old secret is expired immediately,
     * and logins to your client with the old secret will fail.
     *
     * @throws LinodeException
     */
    public function resetSecret(string $id): OAuthClient;
}
