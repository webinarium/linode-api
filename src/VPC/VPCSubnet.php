<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\VPC;

use Linode\Entity;

/**
 * An object describing a VPC Subnet.
 *
 * @property int         $id      The unique ID of the VPC Subnet.
 * @property string      $label   The VPC Subnet's label, for display purposes only.
 *                                * Must be unique among the VPC's Subnets.
 *                                * Can only contain ASCII letters, numbers, and hyphens (`-`). You can't use two
 *                                consecutive hyphens (`--`).
 * @property string      $ipv4    IPv4 range in CIDR canonical form.
 *                                * The range must belong to a private address space as defined in RFC1918.
 *                                * Allowed prefix lengths: 1-29.
 *                                * The range must not overlap with 192.168.128.0/17.
 *                                * The range must not overlap with other Subnets on the same VPC.
 * @property object[]    $linodes An array of Linode IDs assigned to the VPC Subnet.
 *                                A Linode is assigned to a VPC Subnet if it has a Configuration Profile with a
 *                                `vpc` purpose interface with the subnet's `subnet_id`. Even if the Configuration
 *                                Profile is not active, meaning the Linode does not have access to the Subnet, the
 *                                Linode still appears in this array.
 * @property string      $created The date-time of VPC Subnet creation.
 * @property null|string $updated The date-time of the most recent VPC Subnet update.
 */
class VPCSubnet extends Entity
{
    // Available fields.
    public const FIELD_ID      = 'id';
    public const FIELD_LABEL   = 'label';
    public const FIELD_IPV4    = 'ipv4';
    public const FIELD_LINODES = 'linodes';
    public const FIELD_CREATED = 'created';
    public const FIELD_UPDATED = 'updated';
}
