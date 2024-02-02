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

use Linode\Entity;

/**
 * Managed PostgreSQL Databases object.
 *
 * @property int             $id                      A unique ID that can be used to identify and reference the Managed Database.
 * @property string          $label                   A unique, user-defined string referring to the Managed Database.
 * @property string          $region                  The Region ID for the Managed Database.
 * @property string          $type                    The Linode Instance type used by the Managed Database for its nodes.
 * @property int             $cluster_size            The number of Linode Instance nodes deployed to the Managed Database.
 *                                                    Choosing 3 nodes creates a high availability cluster consisting of 1 primary node
 *                                                    and 2 replica nodes.
 * @property string          $engine                  The Managed Database engine type.
 * @property string          $version                 The Managed Database engine version.
 * @property int             $port                    The access port for this Managed Database.
 * @property string          $replication_type        The replication method used for the Managed Database.
 *                                                    Defaults to `none` for a single cluster and `semi_synch` for a high availability
 *                                                    cluster.
 *                                                    Must be `none` for a single node cluster.
 *                                                    Must be `asynch` or `semi_synch` for a high availability cluster.
 * @property string          $status                  The operating status of the Managed Database.
 * @property string          $replication_commit_type The synchronization level of the replicating server.
 *                                                    Must be `local` or `off` for the `asynch` replication type.
 *                                                    Must be `on`, `remote_write`, or `remote_apply` for the `semi_synch` replication
 *                                                    type.
 * @property bool            $encrypted               Whether the Managed Databases is encrypted.
 * @property string[]        $allow_list              A list of IP addresses that can access the Managed Database. Each item can be a
 *                                                    single IP address or a range in CIDR format.
 *                                                    By default, this is an empty array (`[]`), which blocks all connections (both
 *                                                    public and private) to the Managed Database.
 *                                                    If `0.0.0.0/0` is a value in this list, then all IP addresses can access the
 *                                                    Managed Database.
 * @property DatabaseHosts   $hosts                   The primary and secondary hosts for the Managed Database. These are assigned after
 *                                                    provisioning is complete.
 * @property bool            $ssl_connection          Whether to require SSL credentials to establish a connection to the Managed
 *                                                    Database.
 *                                                    Use the **Managed PostgreSQL Database Credentials View** (GET
 *                                                    /databases/postgresql/instances/{instanceId}/credentials) command for access
 *                                                    information.
 * @property string          $created                 When this Managed Database was created.
 * @property string          $updated                 When this Managed Database was last updated.
 * @property DatabaseUpdates $updates                 Configuration settings for automated patch update maintenance for the Managed
 *                                                    Database.
 */
class DatabasePostgreSQL extends Entity
{
    // Available fields.
    public const FIELD_ID                      = 'id';
    public const FIELD_LABEL                   = 'label';
    public const FIELD_REGION                  = 'region';
    public const FIELD_TYPE                    = 'type';
    public const FIELD_CLUSTER_SIZE            = 'cluster_size';
    public const FIELD_ENGINE                  = 'engine';
    public const FIELD_VERSION                 = 'version';
    public const FIELD_PORT                    = 'port';
    public const FIELD_REPLICATION_TYPE        = 'replication_type';
    public const FIELD_STATUS                  = 'status';
    public const FIELD_REPLICATION_COMMIT_TYPE = 'replication_commit_type';
    public const FIELD_ENCRYPTED               = 'encrypted';
    public const FIELD_ALLOW_LIST              = 'allow_list';
    public const FIELD_HOSTS                   = 'hosts';
    public const FIELD_SSL_CONNECTION          = 'ssl_connection';
    public const FIELD_CREATED                 = 'created';
    public const FIELD_UPDATED                 = 'updated';
    public const FIELD_UPDATES                 = 'updates';

    // `FIELD_CLUSTER_SIZE` values.
    public const CLUSTER_SIZE_1 = 1;
    public const CLUSTER_SIZE_3 = 3;

    // `FIELD_REPLICATION_TYPE` values.
    public const REPLICATION_TYPE_NONE       = 'none';
    public const REPLICATION_TYPE_ASYNCH     = 'asynch';
    public const REPLICATION_TYPE_SEMI_SYNCH = 'semi_synch';

    // `FIELD_STATUS` values.
    public const STATUS_PROVISIONING = 'provisioning';
    public const STATUS_ACTIVE       = 'active';
    public const STATUS_SUSPENDING   = 'suspending';
    public const STATUS_SUSPENDED    = 'suspended';
    public const STATUS_RESUMING     = 'resuming';
    public const STATUS_RESTORING    = 'restoring';
    public const STATUS_FAILED       = 'failed';
    public const STATUS_DEGRADED     = 'degraded';
    public const STATUS_UPDATING     = 'updating';
    public const STATUS_BACKING_UP   = 'backing_up';

    // `FIELD_REPLICATION_COMMIT_TYPE` values.
    public const REPLICATION_COMMIT_TYPE_ON           = 'on';
    public const REPLICATION_COMMIT_TYPE_LOCAL        = 'local';
    public const REPLICATION_COMMIT_TYPE_REMOTE_WRITE = 'remote_write';
    public const REPLICATION_COMMIT_TYPE_REMOTE_APPLY = 'remote_apply';
    public const REPLICATION_COMMIT_TYPE_OFF          = 'off';

    /**
     * @codeCoverageIgnore This method was autogenerated.
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            self::FIELD_HOSTS   => new DatabaseHosts($this->client, $this->data[$name]),
            self::FIELD_UPDATES => new DatabaseUpdates($this->client, $this->data[$name]),
            default             => parent::__get($name),
        };
    }
}
