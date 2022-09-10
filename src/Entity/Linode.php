<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity;

use Linode\Internal\Linode\ConfigurationProfileRepository;
use Linode\Internal\Linode\DiskRepository;
use Linode\Internal\Linode\LinodeNetworkRepository;
use Linode\Internal\Linode\LinodeVolumeRepository;

/**
 * A Linode instance.
 *
 * @property int                                                               $id               This Linode's ID which must be provided for all operations impacting
 *                                                                                               this Linode.
 * @property string                                                            $label            The Linode's label is for display purposes only. If no label is
 *                                                                                               provided for a Linode, a default will be assigned.
 * @property string                                                            $region           This is the location where the Linode was deployed. This cannot be
 *                                                                                               changed without opening a support ticket.
 * @property string                                                            $image            An Image ID. Official Linode Images start with `linode/`, while your
 *                                                                                               Images start with `private/`.
 * @property string                                                            $type             This is the Linode Type (@see `LinodeType` class) that this Linode
 *                                                                                               was deployed with.
 * @property string                                                            $status           A brief description of this Linode's current state. This field may
 *                                                                                               change without direct action from you. For instance, the status will
 *                                                                                               change to "running" when the boot process completes
 *                                                                                               (@see `STATUS_...` constants).
 * @property string[]                                                          $ipv4             This Linode's IPv4 Addresses. Each Linode is assigned a single
 *                                                                                               public IPv4 address upon creation, and may get a single private IPv4
 *                                                                                               address if needed. You may need to open a support ticket to get
 *                                                                                               additional IPv4 addresses.
 * @property string                                                            $ipv6             This Linode's IPv6 SLAAC addresses. This address is specific to
 *                                                                                               a Linode, and may not be shared.
 * @property string                                                            $hypervisor       The virtualization software powering this Linode
 *                                                                                               (@see `HYPERVISOR_...` constants).
 * @property bool                                                              $watchdog_enabled The watchdog, named Lassie, is a Shutdown Watchdog that monitors
 *                                                                                               your Linode and will reboot it if it powers off unexpectedly. It
 *                                                                                               works by issuing a boot job when your Linode powers off without
 *                                                                                               a shutdown job being responsible.
 *                                                                                               To prevent a loop, Lassie will give up if there have been more than
 *                                                                                               5 boot jobs issued within 15 minutes.
 * @property string                                                            $created          When this Linode was created.
 * @property string                                                            $updated          When this Linode was last updated.
 * @property string                                                            $group            A property denoting a group label for this Linode.
 * @property string[]                                                          $tags             An array of tags applied to this object. Tags are for organizational
 *                                                                                               purposes only.
 * @property Linode\LinodeSpecs                                                $specs            Information about the resources available to this Linode.
 * @property Linode\LinodeAlerts                                               $alerts           Information about this Linode's notification thresholds.
 * @property Linode\LinodeBackups                                              $backups          Information about this Linode's backups status.
 * @property \Linode\Repository\Linode\ConfigurationProfileRepositoryInterface $configs          Configuration profiles.
 * @property \Linode\Repository\Linode\DiskRepositoryInterface                 $disks            Disks.
 * @property \Linode\Repository\Linode\LinodeNetworkRepositoryInterface        $ips              Network information.
 * @property \Linode\Repository\Linode\LinodeVolumeRepositoryInterface         $volumes          Volumes.
 */
class Linode extends Entity
{
    // Available fields.
    public const FIELD_ID               = 'id';
    public const FIELD_LABEL            = 'label';
    public const FIELD_REGION           = 'region';
    public const FIELD_IMAGE            = 'image';
    public const FIELD_TYPE             = 'type';
    public const FIELD_STATUS           = 'status';
    public const FIELD_IPV4             = 'ipv4';
    public const FIELD_IPV6             = 'ipv6';
    public const FIELD_HYPERVISOR       = 'hypervisor';
    public const FIELD_WATCHDOG_ENABLED = 'watchdog_enabled';
    public const FIELD_CREATED          = 'created';
    public const FIELD_UPDATED          = 'updated';
    public const FIELD_GROUP            = 'group';
    public const FIELD_TAGS             = 'tags';
    public const FIELD_SPECS            = 'specs';
    public const FIELD_ALERTS           = 'alerts';
    public const FIELD_BACKUPS          = 'backups';

    // Extra field for create/update operations.
    public const FIELD_LINODE_ID        = 'linode_id';
    public const FIELD_ROOT_PASS        = 'root_pass';
    public const FIELD_SWAP_SIZE        = 'swap_size';
    public const FIELD_BOOTED           = 'booted';
    public const FIELD_PRIVATE_IP       = 'private_ip';
    public const FIELD_AUTHORIZED_KEYS  = 'authorized_keys';
    public const FIELD_AUTHORIZED_USERS = 'authorized_users';
    public const FIELD_BACKUP_ID        = 'backup_id';
    public const FIELD_BACKUPS_ENABLED  = 'backups_enabled';
    public const FIELD_STACKSCRIPT_ID   = 'stackscript_id';
    public const FIELD_STACKSCRIPT_DATA = 'stackscript_data';
    public const FIELD_DEVICES          = 'devices';
    public const FIELD_DISKS            = 'disks';
    public const FIELD_CONFIGS          = 'configs';

    // Linode statuses.
    public const STATUS_RUNNING       = 'running';
    public const STATUS_OFFLINE       = 'offline';
    public const STATUS_BOOTING       = 'booting';
    public const STATUS_REBOOTING     = 'rebooting';
    public const STATUS_SHUTTING_DOWN = 'shutting_down';
    public const STATUS_PROVISIONING  = 'provisioning';
    public const STATUS_DELETING      = 'deleting';
    public const STATUS_MIGRATING     = 'migrating';
    public const STATUS_REBUILDING    = 'rebuilding';
    public const STATUS_CLONING       = 'cloning';
    public const STATUS_RESTORING     = 'restoring';

    // Hypervisor types.
    public const HYPERVISOR_KVM   = 'kvm';
    public const HYPERVISOR_XEN   = 'xen';
    public const HYPERVISOR_PVOPS = 'pvops';

    /**
     * {@inheritdoc}
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'configs' => new ConfigurationProfileRepository($this->client, $this->id),
            'disks'   => new DiskRepository($this->client, $this->id),
            'ips'     => new LinodeNetworkRepository($this->client, $this->id),
            'volumes' => new LinodeVolumeRepository($this->client, $this->id),
            default   => parent::__get($name),
        };
    }
}
