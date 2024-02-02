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

use Linode\Account\Transfer;
use Linode\Exception\LinodeException;
use Linode\Networking\Firewall;
use Linode\NodeBalancers\NodeBalancer;
use Linode\RepositoryInterface;
use Linode\Volumes\Volume;

/**
 * Linode repository.
 *
 * @method Linode   find(int|string $id)
 * @method Linode[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Linode[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Linode   findOneBy(array $criteria)
 * @method Linode[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface LinodeRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a Linode Instance on your Account. In order for this
     * request to complete successfully, your User must have the `add_linodes` grant.
     * Creating a new Linode will incur a charge on your Account.
     *
     * **Important**: You must be an unrestricted User in order to add or modify
     * tags on Linodes.
     *
     * @param array $parameters The requested initial state of a new Linode.
     *
     * @throws LinodeException
     */
    public function createLinodeInstance(array $parameters = []): Linode;

    /**
     * Updates a Linode that you have permission to `read_write`.
     *
     * **Important**: You must be an unrestricted User in order to add or modify tags on
     * Linodes.
     *
     * @param int   $linodeId   ID of the Linode to look up
     * @param array $parameters Any field that is not marked as `readOnly` may be updated. Fields that are marked
     *                          `readOnly` will be ignored. If any updated field fails to pass validation, the
     *                          Linode will not be updated.
     *
     * @throws LinodeException
     */
    public function updateLinodeInstance(int $linodeId, array $parameters = []): Linode;

    /**
     * Deletes a Linode you have permission to `read_write`.
     *
     * **Deleting a Linode is a destructive action and cannot be undone.**
     *
     * Additionally, deleting a Linode:
     *
     *   * Gives up any IP addresses the Linode was assigned.
     *   * Deletes all Disks, Backups, Configs, etc.
     *   * Stops billing for the Linode and its associated services. You will be billed
     * for time used
     *     within the billing period the Linode was active.
     *
     * Linodes that are in the process of cloning or backup restoration cannot be
     * deleted.
     *
     * @param int $linodeId ID of the Linode to look up
     *
     * @throws LinodeException
     */
    public function deleteLinodeInstance(int $linodeId): void;

    /**
     * Boots a Linode you have permission to modify. If no parameters are given, a Config
     * profile
     * will be chosen for this boot based on the following criteria:
     *
     * * If there is only one Config profile for this Linode, it will be used.
     * * If there is more than one Config profile, the last booted config will be used.
     * * If there is more than one Config profile and none were the last to be booted
     * (because the
     *   Linode was never booted or the last booted config was deleted) an error will be
     * returned.
     *
     * @param int   $linodeId   The ID of the Linode to boot.
     * @param array $parameters Optional configuration to boot into (see above).
     *
     * @throws LinodeException
     */
    public function bootLinodeInstance(int $linodeId, array $parameters = []): void;

    /**
     * You can clone your Linode's existing Disks or Configuration profiles to
     * another Linode on your Account. In order for this request to complete
     * successfully, your User must have the `add_linodes` grant. Cloning to a
     * new Linode will incur a charge on your Account.
     *
     * If cloning to an existing Linode, any actions currently running or
     * queued must be completed first before you can clone to it.
     *
     * Up to five clone operations from any given source Linode can be run concurrently.
     * If more concurrent clones are attempted, an HTTP 400 error will be
     * returned by this endpoint.
     *
     * Any tags existing on the source Linode will be cloned to the target Linode.
     *
     * @param int   $linodeId   ID of the Linode to clone.
     * @param array $parameters The requested state your Linode will be cloned into.
     *
     * @throws LinodeException
     */
    public function cloneLinodeInstance(int $linodeId, array $parameters = []): Linode;

    /**
     * Initiate a pending host migration that has been scheduled by Linode or initiate a
     * cross data center (DC) migration. A list of pending migrations, if any, can be
     * accessed from GET /account/notifications. When the migration begins, your Linode
     * will be shutdown if not already off. If the migration initiated the shutdown, it
     * will reboot the Linode when completed.
     *
     * To initiate a cross DC migration, you must pass a `region` parameter to the
     * request body specifying the target data center region. You can view a list of all
     * available regions and their feature capabilities from GET /regions. If your Linode
     * has a DC migration already queued or you have initiated a previously scheduled
     * migration, you will not be able to initiate a DC migration until it has completed.
     *
     * **Note:** Next Generation Network (NGN) data centers do not support IPv6 `/116`
     * pools or IP Failover. If you have these features enabled on your Linode and
     * attempt to migrate to an NGN data center, the migration will not initiate. If a
     * Linode cannot be migrated because of an incompatibility, you will be prompted to
     * select a different data center or contact support.
     *
     * @param int $linodeId ID of the Linode to migrate.
     *
     * @throws LinodeException
     */
    public function migrateLinodeInstance(int $linodeId, array $parameters = []): void;

    /**
     * Linodes created with now-deprecated Types are entitled to a free upgrade to the
     * next generation. A mutating Linode will be allocated any new resources the
     * upgraded Type provides, and will be subsequently restarted if it was currently
     * running.
     * If any actions are currently running or queued, those actions must be completed
     * first before you can initiate a mutate.
     *
     * @param int   $linodeId   ID of the Linode to mutate.
     * @param array $parameters Whether to automatically resize disks or not.
     *
     * @throws LinodeException
     */
    public function mutateLinodeInstance(int $linodeId, array $parameters = []): void;

    /**
     * Resets the root password for this Linode.
     * * Your Linode must be shut down for a password reset to complete.
     * * If your Linode has more than one disk (not counting its swap disk), use the
     * Reset Disk Root Password endpoint to update a specific disk's root password.
     * * A `password_reset` event is generated when a root password reset is successful.
     *
     * @param int   $linodeId   ID of the Linode for which to reset its root password.
     * @param array $parameters This Linode's new root password.
     *
     * @throws LinodeException
     */
    public function resetLinodePassword(int $linodeId, array $parameters = []): void;

    /**
     * Reboots a Linode you have permission to modify. If any actions are currently
     * running or queued, those actions must be completed first before you can initiate a
     * reboot.
     *
     * @param int   $linodeId   ID of the linode to reboot.
     * @param array $parameters Optional reboot parameters.
     *
     * @throws LinodeException
     */
    public function rebootLinodeInstance(int $linodeId, array $parameters = []): void;

    /**
     * Rebuilds a Linode you have the `read_write` permission to modify.
     * A rebuild will first shut down the Linode, delete all disks and configs on the
     * Linode, and then deploy a new `image` to the Linode with the given attributes.
     * Additionally:
     *
     *   * Requires an `image` be supplied.
     *   * Requires a `root_pass` be supplied to use for the root User's Account.
     *   * It is recommended to supply SSH keys for the root User using the
     *     `authorized_keys` field.
     *
     * @param int   $linodeId   ID of the Linode to rebuild.
     * @param array $parameters The requested state your Linode will be rebuilt into.
     *
     * @throws LinodeException
     */
    public function rebuildLinodeInstance(int $linodeId, array $parameters = []): Linode;

    /**
     * Rescue Mode is a safe environment for performing many system recovery and disk
     * management tasks. Rescue Mode is based on the Finnix recovery distribution, a
     * self-contained and bootable Linux distribution. You can also use Rescue Mode for
     * tasks other than disaster recovery, such as formatting disks to use different
     * filesystems, copying data between disks, and downloading files from a disk via SSH
     * and SFTP.
     * * Note that "sdh" is reserved and unavailable during rescue.
     *
     * @param int   $linodeId   ID of the Linode to rescue.
     * @param array $parameters Optional object of devices to be mounted.
     *
     * @throws LinodeException
     */
    public function rescueLinodeInstance(int $linodeId, array $parameters = []): void;

    /**
     * Resizes a Linode you have the `read_write` permission to a different Type. If any
     * actions are currently running or queued, those actions must be completed first
     * before you can initiate a resize. Additionally, the following criteria must be met
     * in order to resize a Linode:
     *
     *   * The Linode must not have a pending migration.
     *   * Your Account cannot have an outstanding balance.
     *   * The Linode must not have more disk allocation than the new Type allows.
     *     * In that situation, you must first delete or resize the disk to be smaller.
     *
     * @param int   $linodeId   ID of the Linode to resize.
     * @param array $parameters The Type your current Linode will resize to, and whether to attempt to
     *                          automatically resize the Linode's disks.
     *
     * @throws LinodeException
     */
    public function resizeLinodeInstance(int $linodeId, array $parameters = []): void;

    /**
     * Shuts down a Linode you have permission to modify. If any actions are currently
     * running or queued, those actions must be completed first before you can initiate a
     * shutdown.
     *
     * @param int $linodeId ID of the Linode to shutdown.
     *
     * @throws LinodeException
     */
    public function shutdownLinodeInstance(int $linodeId): void;

    /**
     * Returns CPU, IO, IPv4, and IPv6 statistics for your Linode for the past 24 hours.
     *
     * @param int $linodeId ID of the Linode to look up.
     *
     * @throws LinodeException
     */
    public function getLinodeStats(int $linodeId): LinodeStats;

    /**
     * Returns statistics for a specific month. The year/month values must be either a
     * date in the past, or the current month. If the current month, statistics will be
     * retrieved for the past 30 days.
     *
     * @param int $linodeId ID of the Linode to look up.
     * @param int $year     Numeric value representing the year to look up.
     * @param int $month    Numeric value representing the month to look up.
     *
     * @throws LinodeException
     */
    public function getLinodeStatsByYearMonth(int $linodeId, int $year, int $month): LinodeStats;

    /**
     * Returns a Linode's network transfer pool statistics for the current month.
     *
     * @param int $linodeId ID of the Linode to look up.
     *
     * @throws LinodeException
     */
    public function getLinodeTransfer(int $linodeId): Transfer;

    /**
     * Returns a Linode's network transfer statistics for a specific month. The
     * year/month values must be either a date in the past, or the current month.
     *
     * @param int $linodeId ID of the Linode to look up.
     * @param int $year     Numeric value representing the year to look up.
     * @param int $month    Numeric value representing the month to look up.
     *
     * @throws LinodeException
     */
    public function getLinodeTransferByYearMonth(int $linodeId, int $year, int $month): Transfer;

    /**
     * View Firewall information for Firewalls associated with this Linode.
     *
     * @param int $linodeId ID of the Linode to look up.
     *
     * @return Firewall[] Firewalls associated with this Linode.
     *
     * @throws LinodeException
     */
    public function getLinodeFirewalls(int $linodeId): array;

    /**
     * Returns a list of NodeBalancers that are assigned to this Linode and readable by
     * the requesting User.
     *
     * Read permission to a NodeBalancer can be given to a User by accessing the User's
     * Grants Update
     * (PUT /account/users/{username}/grants) endpoint.
     *
     * @param int $linodeId ID of the Linode to look up
     *
     * @return NodeBalancer[] NodeBalancers that are assigned to this Linode and readable by the requesting
     *                        User.
     *
     * @throws LinodeException
     */
    public function getLinodeNodeBalancers(int $linodeId): array;

    /**
     * View Block Storage Volumes attached to this Linode.
     *
     * @param int $linodeId ID of the Linode to look up.
     *
     * @return Volume[] Block Storage Volumes attached to this Linode.
     *
     * @throws LinodeException
     */
    public function getLinodeVolumes(int $linodeId): array;
}
