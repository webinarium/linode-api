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
 * DatabaseMongoDB repository.
 *
 * @method DatabaseMongoDB   find(int|string $id)
 * @method DatabaseMongoDB[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method DatabaseMongoDB[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method DatabaseMongoDB   findOneBy(array $criteria)
 * @method DatabaseMongoDB[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface DatabaseMongoDBRepositoryInterface extends RepositoryInterface
{
    /**
     * Update a Managed MongoDB Database.
     *
     * Requires `read_write` access to the Database.
     *
     * The Database must have an `active` status to perform this command.
     *
     * Updating addresses in the `allow_list` overwrites any existing addresses.
     *
     * * IP addresses and ranges on this list can access the Managed Database. All other
     * sources are blocked.
     *
     * * If `0.0.0.0/0` is a value in this list, then all IP addresses can access the
     * Managed Database.
     *
     * * Entering an empty array (`[]`) blocks all connections (both public and private)
     * to the Managed Database.
     *
     * * **Note**: Updates to the `allow_list` may take a short period of time to
     * complete, making this command inappropriate for rapid successive updates to this
     * property.
     *
     * All Managed Databases include automatic patch updates, which apply security
     * patches and updates to the underlying operating system of the Managed MongoDB
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
     * preferred version. You can then migrate your databases from the original Managed
     * Database cluster to the new one.
     *
     * **Note**: New MongoDB Databases cannot currently be created.
     *
     * @param int   $instanceId The ID of the Managed MongoDB Database.
     * @param array $parameters Updated information for the Managed MongoDB Database.
     *
     * @throws LinodeException
     */
    public function putDatabasesMongoDBInstance(int $instanceId, array $parameters = []): DatabaseMongoDB;

    /**
     * Remove a Managed MongoDB Database from your Account.
     *
     * Requires `read_write` access to the Database.
     *
     * The Database must have an `active`, `failed`, or `degraded` status to perform this
     * command.
     *
     * Only unrestricted Users can access this command, and have access regardless of the
     * acting token's OAuth scopes.
     *
     * **Note**: New MongoDB Databases cannot currently be created.
     *
     * @param int $instanceId The ID of the Managed MongoDB Database.
     *
     * @throws LinodeException
     */
    public function deleteDatabasesMongoDBInstance(int $instanceId): void;

    /**
     * Display all backups for an accessible Managed MongoDB Database.
     *
     * The Database must not be provisioning to perform this command.
     *
     * Database `auto` type backups are created every 24 hours at 0:00 UTC. Each `auto`
     * backup is retained for 7 days.
     *
     * Database `snapshot` type backups are created by accessing the **Managed MongoDB
     * Database Backup Snapshot Create** (POST
     * /databases/mongodb/instances/{instanceId}/backups) command.
     *
     * **Note**: New MongoDB Databases cannot currently be created.
     *
     * @param int $instanceId The ID of the Managed MongoDB Database.
     *
     * @return DatabaseBackup[] List of backups for the Managed MongoDB Database.
     *
     * @throws LinodeException
     */
    public function getDatabasesMongoDBInstanceBackups(int $instanceId): array;

    /**
     * Creates a snapshot backup of a Managed MongoDB Database.
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
     * **Note**: New MongoDB Databases cannot currently be created.
     *
     * @param int   $instanceId The ID of the Managed MongoDB Database.
     * @param array $parameters Information about the snapshot backup to create.
     *
     * @throws LinodeException
     */
    public function postDatabasesMongoDBInstanceBackup(int $instanceId, array $parameters = []): void;

    /**
     * Display information for a single backup for an accessible Managed MongoDB
     * Database.
     *
     * The Database must not be provisioning to perform this command.
     *
     * **Note**: New MongoDB Databases cannot currently be created.
     *
     * @param int $instanceId The ID of the Managed MongoDB Database.
     * @param int $backupId   The ID of the Managed MongoDB Database backup.
     *
     * @throws LinodeException
     */
    public function getDatabasesMongoDBInstanceBackup(int $instanceId, int $backupId): DatabaseBackup;

    /**
     * Delete a single backup for an accessible Managed MongoDB Database.
     *
     * Requires `read_write` access to the Database.
     *
     * The Database must not be provisioning to perform this command.
     *
     * **Note**: New MongoDB Databases cannot currently be created.
     *
     * @param int $instanceId The ID of the Managed MongoDB Database.
     * @param int $backupId   The ID of the Managed MongoDB Database backup.
     *
     * @throws LinodeException
     */
    public function deleteDatabaseMongoDBInstanceBackup(int $instanceId, int $backupId): void;

    /**
     * Restore a backup to a Managed MongoDB Database on your Account.
     *
     * Requires `read_write` access to the Database.
     *
     * The Database must have an `active` status to perform this command.
     *
     * **Note**: Restoring from a backup will erase all existing data on the database
     * instance and replace it with backup data.
     *
     * **Note**: Currently, restoring a backup after resetting Managed Database
     * credentials results in a failed cluster. Please contact Customer Support if this
     * occurs.
     *
     * **Note**: New MongoDB Databases cannot currently be created.
     *
     * @param int $instanceId The ID of the Managed MongoDB Database.
     * @param int $backupId   The ID of the Managed MongoDB Database backup.
     *
     * @throws LinodeException
     */
    public function postDatabasesMongoDBInstanceBackupRestore(int $instanceId, int $backupId): void;

    /**
     * Display the root username and password for an accessible Managed MongoDB Database.
     *
     * The Database must have an `active` status to perform this command.
     *
     * **Note**: New MongoDB Databases cannot currently be created.
     *
     * @param int $instanceId The ID of the Managed MongoDB Database.
     *
     * @throws LinodeException
     */
    public function getDatabasesMongoDBInstanceCredentials(int $instanceId): DatabaseCredentials;

    /**
     * Reset the root password for a Managed MongoDB Database.
     *
     * Requires `read_write` access to the Database.
     *
     * A new root password is randomly generated and accessible with the **Managed
     * MongoDB Database Credentials View** (GET
     * /databases/mongodb/instances/{instanceId}/credentials) command.
     *
     * Only unrestricted Users can access this command, and have access regardless of the
     * acting token's OAuth scopes.
     *
     * **Note**: Note that it may take several seconds for credentials to reset.
     *
     * **Note**: New MongoDB Databases cannot currently be created.
     *
     * @param int $instanceId The ID of the Managed MongoDB Database.
     *
     * @throws LinodeException
     */
    public function postDatabasesMongoDBInstanceCredentialsReset(int $instanceId): void;

    /**
     * Display the SSL CA certificate for an accessible Managed MongoDB Database.
     *
     * The Database must have an `active` status to perform this command.
     *
     * **Note**: New MongoDB Databases cannot currently be created.
     *
     * @param int $instanceId The ID of the Managed MongoDB Database.
     *
     * @throws LinodeException
     */
    public function getDatabasesMongoDBInstanceSSL(int $instanceId): DatabaseSSL;

    /**
     * Apply security patches and updates to the underlying operating system of the
     * Managed MongoDB Database. This function runs during regular maintenance windows,
     * which are configurable with the **Managed MongoDB Database Update** (PUT
     * /databases/mongodb/instances/{instanceId}) command.
     * Requires `read_write` access to the Database.
     *
     * The Database must have an `active` status to perform this command.
     *
     * **Note**:
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
     * **Note**: New MongoDB Databases cannot currently be created.
     *
     * @param int $instanceId The ID of the Managed MongoDB Database.
     *
     * @throws LinodeException
     */
    public function postDatabasesMongoDBInstancePatch(int $instanceId): void;
}
