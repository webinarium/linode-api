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
     * The following conditions apply:
     *   * Backups may not be restored across Regions.
     *   * Only successfully completed Backups that are not undergoing maintenance can be
     * restored.
     *   * The Linode that the Backup is being restored to must not itself be in the
     * process of creating a Backup.
     *
     * {{< note type="warning" title="Warning: UUID Collisions">}}
     * When you restore a backup, the restored disk is assigned the same UUID as the
     * original disk. In most cases, this is acceptable and does not cause issues.
     * However, if you attempt to mount both the original disk and the corresponding
     * restore disk at the same time (by assigning them both to devices in your
     * Configuration Profile's **Block Device Assignment**), you will encounter a UUID
     * "collision".
     *
     * When this happens, the system selects, and mounts, only one of the disks at
     * random. This is due to both disks sharing the same UUID, and your instance *may
     * fail to boot* since it will not be clear which disk is root. If your system does
     * boot, you will not see any immediate indication if you are booted into the
     * restored disk or the original disk, and you will be unable to access both disks at
     * the same time.
     *
     * To avoid this, we recommend only restoring a backup to the same Compute Instance
     * if you do not intend on mounting them at the same time or are comfortable
     * modifying UUIDs. If you need access to files on both the original disk and the
     * restored disk simultaneously (such as needing to copy files between them), we
     * suggest either restoring the backup to a separate Compute Instance or creating a
     * new Compute Instance with the desired `backup_id`.
     *
     * To learn more about block device assignments and viewing your disks' UUIDs, see
     * our guide on Configuration Profiles.
     * {{< /note >}}
     *
     * @param int  $backupId  The ID of the Backup to restore.
     * @param int  $linode_id The ID of the Linode to restore a Backup to.
     * @param bool $overwrite If True, deletes all Disks and Configs on the target Linode before restoring.
     *
     * @throws LinodeException
     */
    public function restoreBackup(int $backupId, int $linode_id, bool $overwrite): void;
}
