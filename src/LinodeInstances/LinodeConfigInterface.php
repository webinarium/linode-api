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
 * The Network Interface to apply to this Linode's configuration profile.
 *
 * @property int           $id           The unique ID representing this Interface.
 * @property null|string   $label        The name of this Interface.
 *                                       For `vlan` purpose Interfaces:
 *                                       * Required.
 *                                       * Must be unique among the Linode's Interfaces (a Linode cannot be attached to the
 *                                       same VLAN multiple times).
 *                                       * Can only contain ASCII letters, numbers, and hyphens (`-`). You can't use two
 *                                       consecutive hyphens (`--`).
 *                                       * If the VLAN label is new, a VLAN is created. Up to 10 VLANs can be created in
 *                                       each data center region. To view your active VLANs, use the VLANs List endpoint.
 *                                       For `public` purpose Interfaces:
 *                                       * In requests, must be an empty string (`""`) or `null` if included.
 *                                       * In responses, always returns `null`.
 *                                       For `vpc` purpose Interfaces:
 *                                       * In requests, must be an empty string (`""`) or `null` if included.
 *                                       * In responses, always returns `null`.
 * @property string        $purpose      The type of Interface.
 *                                       * `public`
 *                                       * Only one `public` Interface per Linode can be defined.
 *                                       * The Linode's default public IPv4 address is assigned to the `public`
 *                                       Interface.
 *                                       * A Linode must have a public Interface in the first/eth0 position to be
 *                                       reachable via the public internet upon boot without additional system
 *                                       configuration. If no `public` Interface is configured, the Linode is not directly
 *                                       reachable via the public internet. In this case, access can only be established
 *                                       via LISH or other Linodes connected to the same VLAN or VPC.
 *                                       * `vlan`
 *                                       * Configuring a `vlan` purpose Interface attaches this Linode to the VLAN with
 *                                       the specified `label`.
 *                                       * The Linode is configured to use the specified `ipam_address`, if any.
 *                                       * `vpc`
 *                                       * Configuring a `vpc` purpose Interface attaches this Linode to the existing VPC
 *                                       Subnet with the specified `subnet_id`.
 *                                       * When the Interface is activated, the Linode is configured to use an IP address
 *                                       from the range in the assigned VPC Subnet. See `ipv4.vpc` for more information.
 * @property null|string   $ipam_address This Network Interface's private IP address in Classless Inter-Domain Routing
 *                                       (CIDR) notation.
 *                                       For `vlan` purpose Interfaces:
 *                                       * Must be unique among the Linode's Interfaces to avoid conflicting addresses.
 *                                       * Should be unique among devices attached to the VLAN to avoid conflict.
 *                                       * The Linode is configured to use this address for the associated Interface upon
 *                                       reboot if Network Helper is enabled. If Network Helper is disabled, the address
 *                                       can be enabled with manual static IP configuration.
 *                                       For `public` purpose Interfaces:
 *                                       * In requests, must be an empty string (`""`) or `null` if included.
 *                                       * In responses, always returns `null`.
 *                                       For `vpc` purpose Interfaces:
 *                                       * In requests, must be an empty string (`""`) or `null` if included.
 *                                       * In responses, always returns `null`.
 * @property bool          $active       Returns `true` if the Interface is in use, meaning that Compute Instance has been
 *                                       booted using the Configuration Profile to which the Interface belongs. Otherwise
 *                                       returns `false`.
 * @property bool          $primary      The primary Interface is configured as the default route to the Linode.
 *                                       Each Configuration Profile can have up to one `"primary": true` Interface at a
 *                                       time.
 *                                       Must be `false` for `vlan` type Interfaces.
 *                                       If no Interface is configured as the primary, the first non-`vlan` type Interface
 *                                       in the `interfaces` array is automatically treated as the primary Interface.
 * @property null|int      $vpc_id       The `id` of the VPC configured for this Interface. Returns `null` for non-`vpc`
 *                                       type Interfaces.
 * @property null|int      $subnet_id    The `id` of the VPC Subnet for this Interface.
 *                                       In requests, this value is used to assign a Linode to a VPC Subnet.
 *                                       * Required for `vpc` type Interfaces.
 *                                       * Returns `null` for non-`vpc` type Interfaces.
 *                                       * Once a VPC Subnet is assigned to an Interface, it cannot be updated.
 *                                       * The Linode must be rebooted with the Interface's Configuration Profile to
 *                                       complete assignment to a VPC Subnet.
 * @property IPv4Config    $ipv4         IPv4 addresses configured for this Interface. Only allowed for `vpc` type
 *                                       Interfaces. Returns `null` if no `vpc` Interface is assigned.
 * @property null|string[] $ip_ranges    An array of IPv4 CIDR VPC Subnet ranges that are routed to this Interface. **IPv6
 *                                       ranges are also available to select participants in the Beta program.**
 *                                       * Array items are only allowed for `vpc` type Interfaces.
 *                                       * This must be empty for non-`vpc` type Interfaces.
 *                                       For requests:
 *                                       * Addresses in submitted ranges must not already be actively assigned.
 *                                       * Submitting values replaces any existing values.
 *                                       * Submitting an empty array removes any existing values.
 *                                       * Omitting this property results in no change to existing values.
 */
class LinodeConfigInterface extends Entity
{
    // Available fields.
    public const FIELD_ID           = 'id';
    public const FIELD_LABEL        = 'label';
    public const FIELD_PURPOSE      = 'purpose';
    public const FIELD_IPAM_ADDRESS = 'ipam_address';
    public const FIELD_ACTIVE       = 'active';
    public const FIELD_PRIMARY      = 'primary';
    public const FIELD_VPC_ID       = 'vpc_id';
    public const FIELD_SUBNET_ID    = 'subnet_id';
    public const FIELD_IPV4         = 'ipv4';
    public const FIELD_IP_RANGES    = 'ip_ranges';

    // `FIELD_PURPOSE` values.
    public const PURPOSE_PUBLIC = 'public';
    public const PURPOSE_VLAN   = 'vlan';
    public const PURPOSE_VPC    = 'vpc';

    /**
     * @codeCoverageIgnore This method was autogenerated.
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            self::FIELD_IPV4 => new IPv4Config($this->client, $this->data[$name]),
            default          => parent::__get($name),
        };
    }
}
