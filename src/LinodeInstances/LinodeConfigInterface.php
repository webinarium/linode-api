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
 *                                     Required for `vlan` purpose interfaces. Must be an empty string or `null` for
 *                                     `public` purpose interfaces.
 *                                     If the VLAN label is new, a VLAN is created. Up to 10 VLANs can be created in each
 *                                     data center region. To view your active VLANs, use the VLANs List endpoint.
 *                                     May only consist of ASCII letters, numbers, and dashes (`-`).
 *                                     Must be unique among the Linode's interfaces.
 * @property null|string $ipam_address This Network Interface's private IP address in Classless Inter-Domain Routing
 *                                     (CIDR) notation.
 *                                     Only used for `vlan` purpose interfaces. Must be an empty string or `null` for
 *                                     `public` purpose interfaces.
 *                                     The Linode is configured to use this address for the associated interface upon
 *                                     reboot if Network Helper is enabled. If Network Helper is disabled, the address
 *                                     can be enabled with manual static IP configuration.
 *                                     Must be unique among the Linode's interfaces.
 * @property string      $purpose      The type of interface.
 *                                     * `public`
 *                                     * Only one `public` interface per Linode can be defined.
 *                                     * The Linode's default public IPv4 address is assigned to the `public`
 *                                     interface.
 *                                     * If no `public` interface is defined, the Linode is not reachable via the
 *                                     public internet; access can only be established via LISH or other Linodes
 *                                     connected to the same VLAN.
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
