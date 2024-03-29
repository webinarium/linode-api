<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Databases;

use Linode\Exception\LinodeException;
use Linode\RepositoryInterface;

/**
 * DatabaseMySQL repository.
 *
 * @method DatabaseMySQL   find(int|string $id)
 * @method DatabaseMySQL[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method DatabaseMySQL[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method DatabaseMySQL   findOneBy(array $criteria)
 * @method DatabaseMySQL[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface DatabaseMySQLRepositoryInterface extends RepositoryInterface
{
    /**
     * **This command is currently only available for customers who already have an
     * active Managed Database.**.
     *
     * Provision a Managed MySQL Database.
     *
     * Restricted Users must have the `add_databases` grant to use this command.
     *
     * New instances can take approximately 15 to 30 minutes to provision.
     *
     * The `allow_list` is used to control access to the Managed Database.
     *
     * * IP addresses and ranges in this list can access the Managed Database. All other
     * sources are blocked.
     *
     * * If `0.0.0.0/0` is a value in this list, then all IP addresses can access the
     * Managed Database.
     *
     * * Entering an empty array (`]`) blocks all connections (both public and private)
     * to the Managed Database.
     *
     * All Managed Databases include automatic, daily backups. Up to seven backups are
     * automatically stored for each Managed Database, providing restore points for each
     * day of the past week.
     *
     * All Managed Databases include automatic patch updates, which apply security
     * patches and updates to the underlying operating system of the Managed MySQL
     * Database during configurable maintenance windows.
     *
     * * If your database cluster is configured with a single node, you will experience
     * downtime during this maintenance window when any updates occur. It's recommended
     * that you adjust this window to match a time that will be the least disruptive for
     * your application and users. You may also want to consider upgrading to a high
     * availability plan to avoid any downtime due to maintenance.
     *
     * * **The database software is not updated automatically.** To upgrade to a new
     * database engine version, consider deploying a new Managed Database with your
     * preferred version. You can then [migrate your databases from the original Managed
     * Database cluster to the new one.
     *
     * * To modify update the maintenance window for a Database, use the **Managed MySQL
     * Database Update** (PUT /databases/mysql/instances/{instanceId}) command.
     *
     * @param array $parameters Information about the Managed MySQL Database you are creating.
     *
     * @throws LinodeException
     */
    public function postDatabasesMySQLInstances(array $parameters = []): DatabaseMySQL;

    /**
     * **This command is currently only available for customers who already have an
     * active Managed Database.**.
     *
     * Update a Managed MySQL Database.
     *
     * Requires `read_write` access to the Database.
     *
     * The Database must have an `active` status to perform this command.
     *
     * Updating addresses in the `allow_list` overwrites any existing addresses.
     *
     * * IP addresses and ranges in this list can access the Managed Database. All other
     * sources are blocked.
     *
     * * If `0.0.0.0/0` is a value in this list, then all IP addresses can access the
     * Managed Database.
     *
     * * Entering an empty array (`]`) blocks all connections (both public and private)
     * to the Managed Database.
     *
     * * **Note**: Updates to the `allow_list` may take a short period of time to
     * complete, making this command inappropriate for rapid successive updates to this
     * property.
     *
     * All Managed Databases include automatic patch updates, which apply security
     * patches and updates to the underlying operating system of the Managed MySQL
     * Database. The maintenance window for these updates is configured with the Managed
     * Database's `updates` property.
     *
     * * If your database cluster is configured with a single node, you will experience
     * downtime during this maintenance window when any updates occur. It's recommended
     * that you adjust this window to match a time that will be the least disruptive for
     * your application and users. You may also want to consider upgrading to a high
     * availability plan to avoid any downtime due to maintenance.
     *
     * * **The database software is not updated automatically.** To upgrade to a new
     * database engine version, consider deploying a new Managed Database with your
     * preferred version. You can then [migrate your databases from the original Managed
     * Database cluster to the new one.
     *
     * @param int   $instanceId The ID of the Managed MySQL Database.
     * @param array $parameters Updated information for the Managed MySQL Database.
     *
     * @throws LinodeException
     */
    public function putDatabasesMySQLInstance(int $instanceId, array $parameters = []): DatabaseMySQL;

    /**
     * **This command is currently only available for customers who already have an
     * active Managed Database.**.
     *
     * Remove a Managed MySQL Database from your Account.
     *
     * Requires `read_write` access to the Database.
     *
     * The Database must have an `active`, `failed`, or `degraded` status to perform this
     * command.
     *
     * Only unrestricted Users can access this command, and have access regardless of the
     * acting token's OAuth scopes.
     *
     * @param int $instanceId The ID of the Managed MySQL Database.
     *
     * @throws LinodeException
     */
    public function deleteDatabasesMySQLInstance(int $instanceId): void;

    /**
     * **This command is currently only available for customers who already have an
     * active Managed Database.**.
     *
     * Display all backups for an accessible Managed MySQL Database.
     *
     * The Database must not be provisioning to perform this command.
     *
     * Database `auto` type backups are created every 24 hours at 0:00 UTC. Each `auto`
     * backup is retained for 7 days.
     *
     * Database `snapshot` type backups are created by accessing the **Managed MySQL
     * Database Backup Snapshot Create** (POST
     * /databases/mysql/instances/{instanceId}/backups) command.
     *
     * @param int $instanceId The ID of the Managed MySQL Database.
     *
     * @return DatabaseBackup[] List of backups for the Managed MySQL Database.
     *
     * @throws LinodeException
     */
    public function getDatabasesMySQLInstanceBackups(int $instanceId): array;

    /**
     * **This command is currently only available for customers who already have an
     * active Managed Database.**.
     *
     * Creates a snapshot backup of a Managed MySQL Database.
     *
     * Requires `read_write` access to the Database.
     *
     * Up to 3 snapshot backups for each Database can be stored at a time. If 3 snapshots
     * have been created for a Database, one must be deleted before another can be made.
     *
     * Backups generated by this command have the type `snapshot`. Snapshot backups may
     * take several minutes to complete, after which they will be accessible to view or
     * restore.
     *
     * The Database must have an `active` status to perform this command. If another
     * backup is in progress, it must complete before a new backup can be initiated.
     *
     * @param int   $instanceId The ID of the Managed MySQL Database.
     * @param array $parameters Information about the snapshot backup to create.
     *
     * @throws LinodeException
     */
    public function postDatabasesMySQLInstanceBackup(int $instanceId, array $parameters = []): void;

    /**
     * **This command is currently only available for customers who already have an
     * active Managed Database.**.
     *
     * Display information for a single backup for an accessible Managed MySQL Database.
     *
     * The Database must not be provisioning to perform this command.
     *
     * @param int $instanceId The ID of the Managed MySQL Database.
     * @param int $backupId   The ID of the Managed MySQL Database backup.
     *
     * @throws LinodeException
     */
    public function getDatabasesMySQLInstanceBackup(int $instanceId, int $backupId): DatabaseBackup;

    /**
     * **This command is currently only available for customers who already have an
     * active Managed Database.**.
     *
     * Delete a single backup for an accessible Managed MySQL Database.
     *
     * Requires `read_write` access to the Database.
     *
     * The Database must not be provisioning to perform this command.
     *
     * @param int $instanceId The ID of the Managed MySQL Database.
     * @param int $backupId   The ID of the Managed MySQL Database backup.
     *
     * @throws LinodeException
     */
    public function deleteDatabaseMySQLInstanceBackup(int $instanceId, int $backupId): void;

    /**
     * **This command is currently only available for customers who already have an
     * active Managed Database.**.
     *
     * Restore a backup to a Managed MySQL Database on your Account.
     *
     * Requires `read_write` access to the Database.
     *
     * The Database must have an `active`, `degraded`, or `failed` status to perform this
     * command.
     *
     * **Note**: Restoring from a backup will erase all existing data on the database
     * instance and replace it with backup data.
     *
     * **Note**: Currently, restoring a backup after resetting Managed Database
     * credentials results in a failed cluster. Please contact Customer Support if this
     * occurs.
     *
     * @param int $instanceId The ID of the Managed MySQL Database.
     * @param int $backupId   The ID of the Managed MySQL Database backup.
     *
     * @throws LinodeException
     */
    public function postDatabasesMySQLInstanceBackupRestore(int $instanceId, int $backupId): void;

    /**
     * **This command is currently only available for customers who already have an
     * active Managed Database.**.
     *
     * Display the root username and password for an accessible Managed MySQL Database.
     *
     * The Database must have an `active` status to perform this command.
     *
     * @param int $instanceId The ID of the Managed MySQL Database.
     *
     * @throws LinodeException
     */
    public function getDatabasesMySQLInstanceCredentials(int $instanceId): DatabaseCredentials;

    /**
     * **This command is currently only available for customers who already have an
     * active Managed Database.**.
     *
     * Reset the root password for a Managed MySQL Database.
     *
     * Requires `read_write` access to the Database.
     *
     * A new root password is randomly generated and accessible with the **Managed MySQL
     * Database Credentials View** (GET
     * /databases/mysql/instances/{instanceId}/credentials) command.
     *
     * Only unrestricted Users can access this command, and have access regardless of the
     * acting token's OAuth scopes.
     *
     * **Note**: Note that it may take several seconds for credentials to reset.
     *
     * @param int $instanceId The ID of the Managed MySQL Database.
     *
     * @throws LinodeException
     */
    public function postDatabasesMySQLInstanceCredentialsReset(int $instanceId): void;

    /**
     * **This command is currently only available for customers who already have an
     * active Managed Database.**.
     *
     * Display the SSL CA certificate for an accessible Managed MySQL Database.
     *
     * The Database must have an `active` status to perform this command.
     *
     * @param int $instanceId The ID of the Managed MySQL Database.
     *
     * @throws LinodeException
     */
    public function getDatabasesMySQLInstanceSSL(int $instanceId): DatabaseSSL;

    /**
     * **This command is currently only available for customers who already have an
     * active Managed Database.**.
     *
     * Apply security patches and updates to the underlying operating system of the
     * Managed MySQL Database. This function runs during regular maintenance windows,
     * which are configurable with the **Managed MySQL Database Update** (PUT
     * /databases/mysql/instances/{instanceId}) command.
     *
     * Requires `read_write` access to the Database.
     *
     * The Database must have an `active` status to perform this command.
     *
     * **Note**
     *
     * * If your database cluster is configured with a single node, you will experience
     * downtime during this maintenance. Consider upgrading to a high availability plan
     * to avoid any downtime due to maintenance.
     *
     * * **The database software is not updated automatically.** To upgrade to a new
     * database engine version, consider deploying a new Managed Database with your
     * preferred version. You can then migrate your databases from the original Managed
     * Database cluster to the new one.
     *
     * @param int $instanceId The ID of the Managed MySQL Database.
     *
     * @throws LinodeException
     */
    public function postDatabasesMySQLInstancePatch(int $instanceId): void;
}
