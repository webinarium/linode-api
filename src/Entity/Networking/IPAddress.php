<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity\Networking;

use Linode\Entity\Entity;

/**
 * An IP address that exists in Linode's system, either IPv4 or IPv6.
 *
 * @property string      $address     The IP address.
 * @property string      $gateway     The default gateway for this address.
 * @property string      $subnet_mask The mask that separates host bits from network bits for this address.
 * @property int         $prefix      The number of bits set in the subnet mask.
 * @property string      $type        The type of address this is (@see `TYPE_...` constants).
 * @property bool        $public      Whether this is a public or private IP address.
 * @property null|string $rdns        The reverse DNS assigned to this address. For public IPv4 addresses,
 *                                    this will be set to a default value provided by Linode if not
 *                                    explicitly set.
 * @property string      $region      The Region this IP address resides in.
 * @property int         $linode_id   The ID of the Linode this address currently belongs to. For IPv4
 *                                    addresses, this is by default the Linode that this address was
 *                                    assigned to on creation, and these addresses my be moved using the
 *                                    `/networking/ipv4/assign` endpoint. For SLAAC and link-local addresses,
 *                                    this value may not be changed.
 */
class IPAddress extends Entity
{
    // Available fields.
    public const FIELD_ADDRESS     = 'address';
    public const FIELD_GATEWAY     = 'gateway';
    public const FIELD_SUBNET_MASK = 'subnet_mask';
    public const FIELD_PREFIX      = 'prefix';
    public const FIELD_TYPE        = 'type';
    public const FIELD_PUBLIC      = 'public';
    public const FIELD_RDNS        = 'rdns';
    public const FIELD_REGION      = 'region';
    public const FIELD_LINODE_ID   = 'linode_id';

    // IP address types.
    public const TYPE_IP4       = 'ipv4';
    public const TYPE_IP6       = 'ipv6';
    public const TYPE_IP6_POOL  = 'ipv6/pool';
    public const TYPE_IP6_RANGE = 'ipv6/range';
}
