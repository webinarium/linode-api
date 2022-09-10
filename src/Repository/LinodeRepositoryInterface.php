<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Repository;

use Linode\Entity\Linode;

/**
 * Linode instance repository.
 */
interface LinodeRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a Linode Instance on your Account. In order for this request
     * to complete successfully, your User must have the `add_linodes` grant.
     * Creating a new Linode will incur a charge on your Account.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function create(array $parameters): Linode;

    /**
     * Updates a Linode that you have permission to `read_write`.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function update(int $id, array $parameters): Linode;

    /**
     * Deletes a Linode you have permission to `read_write`.
     *
     * WARNING! Deleting a Linode is a destructive action and cannot be undone.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function delete(int $id): void;

    /**
     * You can clone your Linode's existing Disks or Configuration profiles to
     * another Linode on your Account. In order for this request to complete
     * successfully, your User must have the `add_linodes` grant. Cloning to a
     * new Linode will incur a charge on your Account.
     *
     * If cloning to an existing Linode, any actions currently running or
     * queued must be completed first before you can clone to it.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function clone(int $id, array $parameters): void;

    /**
     * Rebuilds a Linode you have the `read_write` permission to modify.
     *
     * A rebuild will first shut down the Linode, delete all disks and configs
     * on the Linode, and then deploy a new `image` to the Linode with the given
     * attributes.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function rebuild(int $id, array $parameters): Linode;

    /**
     * Resizes a Linode you have the `read_write` permission to a different
     * Type. If any actions are currently running or queued, those actions must
     * be completed first before you can initiate a resize.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function resize(int $id, string $type): void;

    /**
     * Linodes created with now-deprecated Types are entitled to a free
     * upgrade to the next generation. A mutating Linode will be allocated any new
     * resources the upgraded Type provides, and will be subsequently restarted
     * if it was currently running.
     *
     * If any actions are currently running or queued, those actions must be
     * completed first before you can initiate a mutate.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function mutate(int $id): void;

    /**
     * In some circumstances, a Linode may have pending migrations scheduled that
     * that you can initiate when convenient. In these cases, a Notification
     * will be returned from `/account/notifications`. This endpoint initiates
     * the scheduled migration, which will shut the Linode down, migrate it,
     * and then bring it back to its original state.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function migrate(int $id): void;

    /**
     * Boots a Linode you have permission to modify. If no parameters are given, a Config profile
     * will be chosen for this boot based on the following criteria:
     * - If there is only one Config profile for this Linode, it will be used.
     * - If there is more than one Config profile, the last booted config will be used.
     * - If there is more than one Config profile and none were the last to be booted (because the
     *   Linode was never booted or the last booted config was deleted) an error will be returned.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function boot(int $id, int $config_id = null): void;

    /**
     * Reboots a Linode you have permission to modify. If any actions are currently running or
     * queued, those actions must be completed first before you can initiate a reboot.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function reboot(int $id, int $config_id = null): void;

    /**
     * Shuts down a Linode you have permission to modify. If any actions are currently running or
     * queued, those actions must be completed first before you can initiate a shutdown.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function shutdown(int $id): void;

    /**
     * Rescue Mode is a safe environment for performing many system recovery
     * and disk management tasks. Rescue Mode is based on the Finnix recovery
     * distribution, a self-contained and bootable Linux distribution. You can
     * also use Rescue Mode for tasks other than disaster recovery, such as
     * formatting disks to use different filesystems, copying data between
     * disks, and downloading files from a disk via SSH and SFTP.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function rescue(int $id, array $parameters): void;

    /**
     * @throws \Linode\Exception\LinodeException
     */
    public function enableBackups(int $id): void;

    /**
     * @throws \Linode\Exception\LinodeException
     */
    public function cancelBackups(int $id): void;

    /**
     * Creates a snapshot Backup of a Linode.
     *
     * WARNING! If you already have a snapshot of this Linode, this is a destructive
     * action. The previous snapshot will be deleted.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function createSnapshot(int $id, string $label): Linode\Backup;

    /**
     * Restores a Linode's Backup to the specified Linode.
     *
     * @param int  $source_id the ID of the Linode that the Backup belongs to
     * @param int  $backup_id the ID of the Backup to restore
     * @param int  $target_id the ID of the Linode to restore a Backup to
     * @param bool $overwrite if `true`, deletes all Disks and Configs on the target Linode before restoring
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function restoreBackup(int $source_id, int $backup_id, int $target_id, bool $overwrite = true): void;

    /**
     * @throws \Linode\Exception\LinodeException
     */
    public function getBackup(int $id, int $backup_id): Linode\Backup;

    /**
     * @throws \Linode\Exception\LinodeException
     */
    public function getAllBackups(int $id): array;

    /**
     * View the Linode's current statistics for the past 24 hours.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function getCurrentStats(int $id): Linode\LinodeStats;

    /**
     * Returns statistics for a specific month. The year/month
     * values must be either a date in the past, or the current month. If the
     * current month, statistics will be retrieved for the past 30 days.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function getMonthlyStats(int $id, int $year, int $month): Linode\LinodeStats;
}
