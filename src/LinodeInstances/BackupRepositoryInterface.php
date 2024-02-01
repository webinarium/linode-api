<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\LinodeInstances;

use Linode\Exception\LinodeException;
use Linode\RepositoryInterface;

/**
 * Backup repository.
 *
 * @method Backup   find(int|string $id)
 * @method Backup[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Backup[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Backup   findOneBy(array $criteria)
 * @method Backup[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface BackupRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a snapshot Backup of a Linode.
     *
     * **Important:** If you already have a snapshot of this Linode, this is a
     * destructive
     * action. The previous snapshot will be deleted.
     *
     * @throws LinodeException
     */
    public function createSnapshot(array $parameters = []): Backup;

    /**
     * Cancels the Backup service on the given Linode. Deletes all of this Linode's
     * existing backups forever.
     *
     * @throws LinodeException
     */
    public function cancelBackups(): void;

    /**
     * Enables backups for the specified Linode.
     *
     * @throws LinodeException
     */
    public function enableBackups(): void;

    /**
     * Restores a Linode's Backup to the specified Linode.
     *
     * @param int  $backupId  The ID of the Backup to restore.
     * @param int  $linode_id The ID of the Linode to restore a Backup to.
     * @param bool $overwrite If True, deletes all Disks and Configs on the target Linode before restoring.
     *
     * @throws LinodeException
     */
    public function restoreBackup(int $backupId, int $linode_id, bool $overwrite): void;
}
