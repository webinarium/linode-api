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
 * SSHKey repository.
 *
 * @method SSHKey   find(int|string $id)
 * @method SSHKey[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method SSHKey[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method SSHKey   findOneBy(array $criteria)
 * @method SSHKey[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface SSHKeyRepositoryInterface extends RepositoryInterface
{
    /**
     * Adds an SSH Key to your Account profile.
     *
     * @param array $parameters Add SSH Key
     *
     * @throws LinodeException
     */
    public function addSSHKey(array $parameters = []): SSHKey;

    /**
     * Updates an SSH Key that you have permission to `read_write`.
     *
     * Only SSH key labels can be updated.
     *
     * @param int   $sshKeyId   The ID of the SSHKey
     * @param array $parameters The fields to update.
     *
     * @throws LinodeException
     */
    public function updateSSHKey(int $sshKeyId, array $parameters = []): SSHKey;

    /**
     * Deletes an SSH Key you have access to.
     *
     * **Note:** deleting an SSH Key will *not* remove it from any Linode or Disk that
     * was deployed with `authorized_keys`. In those cases, the keys must be manually
     * deleted on the Linode or Disk. This endpoint will only delete the key's
     * association from your Profile.
     *
     * @param int $sshKeyId The ID of the SSHKey
     *
     * @throws LinodeException
     */
    public function deleteSSHKey(int $sshKeyId): void;
}
