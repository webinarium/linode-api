<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Managed;

use Linode\Exception\LinodeException;
use Linode\RepositoryInterface;

/**
 * ManagedCredential repository.
 *
 * @method ManagedCredential   find(int|string $id)
 * @method ManagedCredential[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method ManagedCredential[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method ManagedCredential   findOneBy(array $criteria)
 * @method ManagedCredential[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface ManagedCredentialRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a Managed Credential. A Managed Credential is stored securely to allow
     * Linode special forces to access your Managed Services and resolve issues.
     *
     * @param array $parameters Information about the Credential to create.
     *
     * @throws LinodeException
     */
    public function createManagedCredential(array $parameters = []): ManagedCredential;

    /**
     * Updates the label of a Managed Credential. This endpoint does not update the
     * username and password for a Managed Credential. To do this, use the Managed
     * Credential Username and Password Update (POST
     * /managed/credentials/{credentialId}/update) endpoint instead.
     *
     * @param int   $credentialId The ID of the Credential to access.
     * @param array $parameters   The fields to update.
     *
     * @throws LinodeException
     */
    public function updateManagedCredential(int $credentialId, array $parameters = []): ManagedCredential;

    /**
     * Updates the username and password for a Managed Credential.
     *
     * @param int         $credentialId The ID of the Credential to update.
     * @param null|string $username     The username to use when accessing the Managed Service.
     * @param string      $password     The password to use when accessing the Managed Service.
     *
     * @throws LinodeException
     */
    public function updateManagedCredentialUsernamePassword(int $credentialId, ?string $username, string $password): void;

    /**
     * Deletes a Managed Credential. Linode special forces will no longer have access to
     * this Credential when attempting to resolve issues.
     *
     * @param int $credentialId The ID of the Credential to access.
     *
     * @throws LinodeException
     */
    public function deleteManagedCredential(int $credentialId): void;

    /**
     * Returns the unique SSH public key assigned to your Linode account's Managed
     * service. If you add this public key to a Linode on your account, Linode special
     * forces will be able to log in to the Linode with this key when attempting to
     * resolve issues.
     *
     * @return string The unique SSH public key assigned to your Linode account's Managed service.
     *
     * @throws LinodeException
     */
    public function viewManagedSSHKey(): string;
}
