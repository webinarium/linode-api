<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Networking;

use Linode\Entity;

/**
 * A private IPv4 address that exists in Linode's system.
 *
 * @property string      $address     The private IPv4 address.
 * @property string      $type        The type of address this is.
 * @property bool        $public      Whether this is a public or private IP address.
 * @property string      $rdns        The reverse DNS assigned to this address.
 * @property string      $region      The Region this address resides in.
 * @property int         $linode_id   The ID of the Linode this address currently belongs to.
 * @property null|string $gateway     The default gateway for this address.
 * @property string      $subnet_mask The mask that separates host bits from network bits for this address.
 * @property int         $prefix      The number of bits set in the subnet mask.
 */
class IPAddressPrivate extends Entity
{
    // Available fields.
    public const FIELD_ADDRESS     = 'address';
    public const FIELD_TYPE        = 'type';
    public const FIELD_PUBLIC      = 'public';
    public const FIELD_RDNS        = 'rdns';
    public const FIELD_REGION      = 'region';
    public const FIELD_LINODE_ID   = 'linode_id';
    public const FIELD_GATEWAY     = 'gateway';
    public const FIELD_SUBNET_MASK = 'subnet_mask';
    public const FIELD_PREFIX      = 'prefix';
}
