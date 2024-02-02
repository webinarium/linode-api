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
 * @property null|string $label        The name of this interface.
 *                                     For `vlan` purpose interfaces:
 *                                     * Required.
 *                                     * Must be unique among the Linode's interfaces (a Linode cannot be attached to the
 *                                     same VLAN multiple times).
 *                                     * May only consist of ASCII letters, numbers, and dashes (`-`).
 *                                     For `public` purpose interfaces:
 *                                     * In requests, must be an empty string (`""`) or `null` if included.
 *                                     * In responses, always returns `null`.
 *                                     If the VLAN label is new, a VLAN is created. Up to 10 VLANs can be created in each
 *                                     data center region. To view your active VLANs, use the VLANs List endpoint.
 * @property null|string $ipam_address This Network Interface's private IP address in Classless Inter-Domain Routing
 *                                     (CIDR) notation.
 *                                     For `vlan` purpose interfaces:
 *                                     * Must be unique among the Linode's interfaces to avoid conflicting addresses.
 *                                     * Should be unique among devices attached to the VLAN to avoid conflict.
 *                                     For `public` purpose interfaces:
 *                                     * In requests, must be an empty string (`""`) or `null` if included.
 *                                     * In responses, always returns `null`.
 *                                     The Linode is configured to use this address for the associated interface upon
 *                                     reboot if Network Helper is enabled. If Network Helper is disabled, the address
 *                                     can be enabled with manual static IP configuration.
 * @property string      $purpose      The type of interface.
 *                                     * `public`
 *                                     * Only one `public` interface per Linode can be defined.
 *                                     * The Linode's default public IPv4 address is assigned to the `public`
 *                                     interface.
 *                                     * A Linode must have a public interface in the first/eth0 position to be
 *                                     reachable via the public internet upon boot without additional system
 *                                     configuration. If no `public` interface is configured, the Linode is not directly
 *                                     reachable via the public internet. In this case, access can only be established
 *                                     via LISH or other Linodes connected to the same VLAN.
 *                                     * `vlan`
 *                                     * Configuring a `vlan` purpose interface attaches this Linode to the VLAN with
 *                                     the specified `label`.
 *                                     * The Linode is configured to use the specified `ipam_address`, if any.
 */
class LinodeConfigInterface extends Entity
{
    // Available fields.
    public const FIELD_LABEL        = 'label';
    public const FIELD_IPAM_ADDRESS = 'ipam_address';
    public const FIELD_PURPOSE      = 'purpose';

    // `FIELD_PURPOSE` values.
    public const PURPOSE_PUBLIC = 'public';
    public const PURPOSE_VLAN   = 'vlan';
}
