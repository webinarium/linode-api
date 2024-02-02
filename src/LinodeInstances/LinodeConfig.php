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

/**
 * Configuration profile associated with a Linode.
 *
 * @property int                     $id           The ID of this Config.
 * @property string                  $label        The Config's label is for display purposes only.
 * @property string                  $kernel       A Kernel ID to boot a Linode with. Defaults to "linode/latest-64bit".
 * @property null|string             $comments     Optional field for arbitrary User comments on this Config.
 * @property int                     $memory_limit Defaults to the total RAM of the Linode.
 * @property string                  $run_level    Defines the state of your Linode after booting. Defaults to `default`.
 * @property string                  $virt_mode    Controls the virtualization mode. Defaults to `paravirt`.
 *                                                 * `paravirt` is suitable for most cases. Linodes running in paravirt mode
 *                                                 share some qualities with the host, ultimately making it run faster since
 *                                                 there is less transition between it and the host.
 *                                                 * `fullvirt` affords more customization, but is slower because 100% of the VM
 *                                                 is virtualized.
 * @property LinodeConfigInterface[] $interfaces   An array of Network Interfaces to add to this Linode's Configuration Profile.
 *                                                 Up to three interface objects can be entered in this array. The position in the
 *                                                 array determines the interface to which the settings apply:
 *                                                 - First/0:  eth0
 *                                                 - Second/1: eth1
 *                                                 - Third/2:  eth2
 *                                                 When updating a Linode's interfaces, *each interface must be redefined*. An empty
 *                                                 interfaces array results in a default public interface configuration only.
 *                                                 If no public interface is configured, public IP addresses are still assigned to
 *                                                 the Linode but will not be usable without manual configuration.
 *                                                 **Note:** Changes to Linode interface configurations can be enabled by rebooting
 *                                                 the Linode.
 *                                                 **Note:** Only Next Generation Network (NGN) data centers support VLANs. Use the
 *                                                 Regions (/regions) endpoint to view the capabilities of data center regions.
 *                                                 If a VLAN is attached to your Linode and you attempt to migrate or clone it to a
 *                                                 non-NGN data center,
 *                                                 the migration or cloning will not initiate. If a Linode cannot be migrated because
 *                                                 of an incompatibility,
 *                                                 you will be prompted to select a different data center or contact support.
 *                                                 **Note:** See our guide on Getting Started with VLANs to view additional
 *                                                 limitations.
 * @property Helpers                 $helpers      Helpers enabled when booting to this Linode Config.
 * @property Devices                 $devices      A dictionary of device disks to use as a device map in a Linode's configuration
 *                                                 profile.
 *                                                 * An empty device disk dictionary or a dictionary with empty values for device
 *                                                 slots is allowed.
 *                                                 * If no devices are specified, booting from this configuration will hold until a
 *                                                 device exists that allows the boot process to start.
 * @property string                  $root_device  The root device to boot.
 *                                                 * If no value or an invalid value is provided, root device will default to
 *                                                 `/dev/sda`.
 *                                                 * If the device specified at the root device location is not mounted, the Linode
 *                                                 will not boot until a device is mounted.
 */
class LinodeConfig extends Entity
{
    // Available fields.
    public const FIELD_ID           = 'id';
    public const FIELD_LABEL        = 'label';
    public const FIELD_KERNEL       = 'kernel';
    public const FIELD_COMMENTS     = 'comments';
    public const FIELD_MEMORY_LIMIT = 'memory_limit';
    public const FIELD_RUN_LEVEL    = 'run_level';
    public const FIELD_VIRT_MODE    = 'virt_mode';
    public const FIELD_INTERFACES   = 'interfaces';
    public const FIELD_HELPERS      = 'helpers';
    public const FIELD_DEVICES      = 'devices';
    public const FIELD_ROOT_DEVICE  = 'root_device';

    // `FIELD_RUN_LEVEL` values.
    public const RUN_LEVEL_DEFAULT = 'default';
    public const RUN_LEVEL_SINGLE  = 'single';
    public const RUN_LEVEL_BINBASH = 'binbash';

    // `FIELD_VIRT_MODE` values.
    public const VIRT_MODE_PARAVIRT = 'paravirt';
    public const VIRT_MODE_FULLVIRT = 'fullvirt';

    /**
     * @codeCoverageIgnore This method was autogenerated.
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            self::FIELD_INTERFACES => array_map(fn ($data) => new LinodeConfigInterface($this->client, $data), $this->data[$name]),
            self::FIELD_HELPERS    => new Helpers($this->client, $this->data[$name]),
            self::FIELD_DEVICES    => new Devices($this->client, $this->data[$name]),
            default                => parent::__get($name),
        };
    }
}
