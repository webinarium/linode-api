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

use Linode\Entity;
use Linode\LinodeInstances\Repository\BackupRepository;
use Linode\LinodeInstances\Repository\DiskRepository;
use Linode\LinodeInstances\Repository\LinodeConfigRepository;

/**
 * A Linode instance.
 *
 * @property int                             $id               This Linode's ID which must be provided for all operations impacting this Linode.
 * @property string                          $label            The Linode's label is for display purposes only. If no label is provided for a
 *                                                             Linode,
 *                                                             a default will be assigned.
 *                                                             Linode labels have the following constraints:
 *                                                             * Must begin and end with an alphanumeric character.
 *                                                             * May only consist of alphanumeric characters, hyphens (`-`), underscores (`_`)
 *                                                             or periods (`.`).
 *                                                             * Cannot have two hyphens (`--`), underscores (`__`) or periods (`..`) in a row.
 * @property string                          $region           This is the Region where the Linode was deployed. A Linode's region can only be
 *                                                             changed by initiating a cross data center migration.
 * @property string                          $type             This is the Linode Type that this Linode was deployed with.
 *                                                             To change a Linode's Type, use POST /linode/instances/{linodeId}/resize.
 * @property null|string                     $image            An Image ID to deploy the Disk from. Official Linode Images start with `linode/ `,
 *                                                             while your Images start with `private/`.
 * @property string                          $status           A brief description of this Linode's current state. This field may change without
 *                                                             direct action from you. For example, when a Linode goes into maintenance mode its
 *                                                             status will display "stopped".
 * @property string[]                        $ipv4             This Linode's IPv4 Addresses. Each Linode is assigned a single public IPv4 address
 *                                                             upon creation, and may get a single private IPv4 address if needed. You may need
 *                                                             to
 *                                                             open a support ticket
 *                                                             to get additional IPv4 addresses.
 *                                                             IPv4 addresses may be reassigned between your Linodes, or shared with other
 *                                                             Linodes.
 *                                                             See the /networking endpoints for details.
 * @property null|string                     $ipv6             This Linode's IPv6 SLAAC address. This address is specific to a Linode, and may
 *                                                             not be shared. If the Linode has not been assigned an IPv6 address, the return
 *                                                             value will be `null`.
 * @property string                          $group            A deprecated property denoting a group label for this Linode.
 * @property string[]                        $tags             An array of tags applied to this object. Tags are for organizational purposes
 *                                                             only.
 * @property string                          $hypervisor       The virtualization software powering this Linode.
 * @property bool                            $watchdog_enabled The watchdog, named Lassie, is a Shutdown Watchdog that monitors your Linode and
 *                                                             will reboot it if it powers off unexpectedly. It works by issuing a boot job when
 *                                                             your Linode powers off without a shutdown job being responsible.
 *                                                             To prevent a loop, Lassie will give up if there have been more than 5 boot jobs
 *                                                             issued within 15 minutes.
 * @property string                          $created          When this Linode was created.
 * @property string                          $updated          When this Linode was last updated.
 * @property LinodeSpecs                     $specs            Information about the resources available to this Linode.
 * @property LinodeAlerts                    $alerts           Information about this Linode's notification thresholds.
 * @property LinodeBackups                   $backups          Information about this Linode's backups status. For information about available
 *                                                             backups, see /linode/instances/{linodeId}/backups.
 * @property string                          $host_uuid        The Linode's host machine, as a UUID.
 * @property bool                            $has_user_data    Whether this compute instance was provisioned utilizing `user_data` provided via
 *                                                             the Metadata service. See the Linode Create description for more information on
 *                                                             Metadata.
 * @property BackupRepositoryInterface       $linodeBackups    Linode backups.
 * @property DiskRepositoryInterface         $linodeDisks      Linode disks.
 * @property LinodeConfigRepositoryInterface $linodeConfigs    Linode configs.
 */
class Linode extends Entity
{
    // Available fields.
    public const FIELD_ID               = 'id';
    public const FIELD_LABEL            = 'label';
    public const FIELD_REGION           = 'region';
    public const FIELD_TYPE             = 'type';
    public const FIELD_IMAGE            = 'image';
    public const FIELD_STATUS           = 'status';
    public const FIELD_IPV4             = 'ipv4';
    public const FIELD_IPV6             = 'ipv6';
    public const FIELD_GROUP            = 'group';
    public const FIELD_TAGS             = 'tags';
    public const FIELD_HYPERVISOR       = 'hypervisor';
    public const FIELD_WATCHDOG_ENABLED = 'watchdog_enabled';
    public const FIELD_CREATED          = 'created';
    public const FIELD_UPDATED          = 'updated';
    public const FIELD_SPECS            = 'specs';
    public const FIELD_ALERTS           = 'alerts';
    public const FIELD_BACKUPS          = 'backups';
    public const FIELD_HOST_UUID        = 'host_uuid';
    public const FIELD_HAS_USER_DATA    = 'has_user_data';

    // Extra fields for POST/PUT requests.
    public const FIELD_ALLOW_AUTO_DISK_RESIZE = 'allow_auto_disk_resize';
    public const FIELD_BACKUPS_ENABLED        = 'backups_enabled';
    public const FIELD_BOOTED                 = 'booted';
    public const FIELD_PRIVATE_IP             = 'private_ip';
    public const FIELD_ROOT_PASS              = 'root_pass';
    public const FIELD_SWAP_SIZE              = 'swap_size';
    public const FIELD_AUTHORIZED_KEYS        = 'authorized_keys';
    public const FIELD_AUTHORIZED_USERS       = 'authorized_users';
    public const FIELD_STACKSCRIPT_ID         = 'stackscript_id';
    public const FIELD_STACKSCRIPT_DATA       = 'stackscript_data';
    public const FIELD_BACKUP_ID              = 'backup_id';
    public const FIELD_CONFIG_ID              = 'config_id';
    public const FIELD_LINODE_ID              = 'linode_id';
    public const FIELD_CONFIGS                = 'configs';
    public const FIELD_DEVICES                = 'devices';
    public const FIELD_DISKS                  = 'disks';

    // `FIELD_STATUS` values.
    public const STATUS_RUNNING            = 'running';
    public const STATUS_OFFLINE            = 'offline';
    public const STATUS_BOOTING            = 'booting';
    public const STATUS_REBOOTING          = 'rebooting';
    public const STATUS_SHUTTING_DOWN      = 'shutting_down';
    public const STATUS_PROVISIONING       = 'provisioning';
    public const STATUS_DELETING           = 'deleting';
    public const STATUS_MIGRATING          = 'migrating';
    public const STATUS_REBUILDING         = 'rebuilding';
    public const STATUS_CLONING            = 'cloning';
    public const STATUS_RESTORING          = 'restoring';
    public const STATUS_STOPPED            = 'stopped';
    public const STATUS_BILLING_SUSPENSION = 'billing_suspension';

    // `FIELD_HYPERVISOR` values.
    public const HYPERVISOR_KVM = 'kvm';

    /**
     * @codeCoverageIgnore This method was autogenerated.
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            self::FIELD_SPECS   => new LinodeSpecs($this->client, $this->data[$name]),
            self::FIELD_ALERTS  => new LinodeAlerts($this->client, $this->data[$name]),
            self::FIELD_BACKUPS => new LinodeBackups($this->client, $this->data[$name]),
            'linodeBackups'     => new BackupRepository($this->client, $this->id),
            'linodeDisks'       => new DiskRepository($this->client, $this->id),
            'linodeConfigs'     => new LinodeConfigRepository($this->client, $this->id),
            default             => parent::__get($name),
        };
    }
}
