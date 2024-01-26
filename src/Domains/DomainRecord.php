<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Domains;

use Linode\Entity;

/**
 * A single record on a Domain.
 *
 * @property int         $id       This Record's unique ID.
 * @property string      $type     The type of Record this is in the DNS system. For example, A records associate a
 *                                 domain name with an IPv4 address, and AAAA records associate a domain name with an
 *                                 IPv6 address.
 * @property string      $name     The name of this Record. This field's actual usage depends on the type of record
 *                                 this represents. For A and AAAA records, this is the subdomain being associated
 *                                 with an IP address.
 * @property string      $target   The target for this Record. This field's actual usage depends on the type of
 *                                 record this represents. For A and AAAA records, this is the address the named
 *                                 Domain should resolve to.
 * @property int         $ttl_sec  "Time to Live" - the amount of time in seconds that this Domain's records may be
 *                                 cached by resolvers or other domain servers. Valid values are 300, 3600, 7200,
 *                                 14400, 28800, 57600, 86400, 172800, 345600, 604800, 1209600, and 2419200 - any
 *                                 other value will be rounded to the nearest valid value.
 * @property int         $priority The priority of the target host. Lower values are preferred.
 * @property int         $weight   The relative weight of this Record. Higher values are preferred.
 * @property null|string $service  The service this Record identified. Only valid for SRV records.
 * @property null|string $protocol The protocol this Record's service communicates with. Only valid for SRV records.
 * @property int         $port     The port this Record points to.
 * @property null|string $tag      The tag portion of a CAA record. It is invalid to set this on other record types.
 */
class DomainRecord extends Entity
{
    // Available fields.
    public const FIELD_ID       = 'id';
    public const FIELD_TYPE     = 'type';
    public const FIELD_NAME     = 'name';
    public const FIELD_TARGET   = 'target';
    public const FIELD_TTL_SEC  = 'ttl_sec';
    public const FIELD_PRIORITY = 'priority';
    public const FIELD_WEIGHT   = 'weight';
    public const FIELD_SERVICE  = 'service';
    public const FIELD_PROTOCOL = 'protocol';
    public const FIELD_PORT     = 'port';
    public const FIELD_TAG      = 'tag';

    // `FIELD_TYPE` values.
    public const TYPE_A     = 'A';
    public const TYPE_AAAA  = 'AAAA';
    public const TYPE_NS    = 'NS';
    public const TYPE_MX    = 'MX';
    public const TYPE_CNAME = 'CNAME';
    public const TYPE_TXT   = 'TXT';
    public const TYPE_SRV   = 'SRV';
    public const TYPE_PTR   = 'PTR';
    public const TYPE_CAA   = 'CAA';
}
