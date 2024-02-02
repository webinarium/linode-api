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
 *                                 IPv6 address. For more information, see our guide on DNS Records.
 * @property string      $name     The name of this Record. For requests, this property's actual usage and whether it
 *                                 is required depends
 *                                 on the type of record this represents:
 *                                 `A` and `AAAA`: The hostname or FQDN of the Record.
 *                                 `NS`: The subdomain, if any, to use with the Domain of the Record.
 *                                 `MX`: The mail subdomain. For example, `sub` for the address
 *                                 `user@sub.example.com` under the `example.com`
 *                                 Domain. Must be an empty string (`""`) for a Null MX Record.
 *                                 `CNAME`: The hostname. Must be unique. Required.
 *                                 `TXT`: The hostname.
 *                                 `SRV`: Unused. Use the `service` property to set the service name for this record.
 *                                 `CAA`: The subdomain. Omit or enter an empty string (`""`) to apply to the entire
 *                                 Domain.
 *                                 `PTR`: See our guide on how to Configure Your Linode for Reverse DNS
 *                                 (rDNS).
 * @property string      $target   The target for this Record. For requests, this property's actual usage and whether
 *                                 it is required depends
 *                                 on the type of record this represents:
 *                                 `A` and `AAAA`: The IP address. Use `remote_addr]` to submit the IPv4 address of
 *                                 the request. Required.
 *                                 `NS`: The name server. Must be a valid domain. Required.
 *                                 `MX`: The mail server. Must be a valid domain unless creating a Null MX Record. To
 *                                 create a
 *                                 [Null MX Record, first
 *                                 remove any additional MX records, create an MX record with empty strings
 *                                 (`""`) for the `target` and `name`. If a Domain has a Null MX record, new MX
 *                                 records cannot be created. Required.
 *                                 `CNAME`: The alias. Must be a valid domain. Required.
 *                                 `TXT`: The value. Required.
 *                                 `SRV`: The target domain or subdomain. If a subdomain is entered, it is
 *                                 automatically used with the Domain.
 *                                 To configure for a different domain, enter a valid FQDN. For example, the value
 *                                 `www` with a Domain for
 *                                 `example.com` results in a target set to `www.example.com`, whereas the value
 *                                 `sample.com` results in a
 *                                 target set to `sample.com`. Required.
 *                                 `CAA`: The value. For `issue` or `issuewild` tags, the domain of your certificate
 *                                 issuer. For the `iodef`
 *                                 tag, a contact or submission URL (http or mailto).
 *                                 `PTR`: See our guide on how to Configure Your Linode for Reverse DNS
 *                                 (rDNS).
 *                                 With the exception of A, AAAA, and CAA records, this field accepts a trailing
 *                                 period.
 * @property int         $ttl_sec  "Time to Live" - the amount of time in seconds that this Domain's records may be
 *                                 cached by resolvers or other domain servers. Valid values are 300, 3600, 7200,
 *                                 14400, 28800, 57600, 86400, 172800, 345600, 604800, 1209600, and 2419200 - any
 *                                 other value will be rounded to the nearest valid value.
 * @property int         $priority The priority of the target host for this Record. Lower values are preferred. Only
 *                                 valid for
 *                                 MX and SRV record requests. Required for SRV record requests.
 *                                 Defaults to `0` for MX record requests. Must be `0` for Null MX records.
 * @property int         $weight   The relative weight of this Record used in the case of identical priority. Higher
 *                                 values are preferred. Only valid and required for SRV record requests.
 * @property null|string $service  The name of the service. An underscore (`_`) is prepended and a period (`.`) is
 *                                 appended automatically to the submitted value for this property. Only valid and
 *                                 required for SRV record requests.
 * @property null|string $protocol The protocol this Record's service communicates with. An underscore (`_`) is
 *                                 prepended automatically to the submitted value for this property. Only valid for
 *                                 SRV record requests.
 * @property int         $port     The port this Record points to. Only valid and required for SRV record requests.
 * @property null|string $tag      The tag portion of a CAA record. Only valid and required for CAA record requests.
 * @property string      $created  When this Domain Record was created.
 * @property string      $updated  When this Domain Record was last updated.
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
    public const FIELD_CREATED  = 'created';
    public const FIELD_UPDATED  = 'updated';

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

    // `FIELD_TAG` values.
    public const TAG_ISSUE     = 'issue';
    public const TAG_ISSUEWILD = 'issuewild';
    public const TAG_IODEF     = 'iodef';
}
