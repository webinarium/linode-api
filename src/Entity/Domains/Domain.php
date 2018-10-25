<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity\Domains;

use Linode\Entity\Entity;
use Linode\Internal\Domains\DomainRecordRepository;

/**
 * A domain zonefile in our DNS system. You must own the domain name and
 * tell your registrar to use Linode's nameservers in order for a domain
 * in our system to be treated as authoritative.
 *
 * @property int      $id          This Domain's unique ID.
 * @property string   $domain      The domain this Domain represents. These must be unique in our system;
 *                                 you cannot have two Domains representing the same domain.
 * @property string   $type        If this Domain represents the authoritative source of information for
 *                                 the domain it describes, or if it is a read-only copy of a master
 *                                 (also called a slave) (@see `TYPE_...` constants).
 * @property string   $status      Used to control whether this Domain is currently being rendered
 *                                 (@see `STATUS_...` constants).
 * @property string   $soa_email   Start of Authority email address. This is required for master Domains.
 * @property string   $group       The group this Domain belongs to. This is for display purposes only (@deprecated).
 * @property string   $description A description for this Domain. This is for display purposes only.
 * @property int      $ttl_sec     "Time to Live" - the amount of time in seconds that this Domain's records may
 *                                 be cached by resolvers or other domain servers (@see `TIME_...` constants).
 * @property int      $refresh_sec The amount of time in seconds before this Domain should be refreshed
 *                                 (@see `TIME_...` constants).
 * @property int      $retry_sec   The interval, in seconds, at which a failed refresh should be retried
 *                                 (@see `TIME_...` constants).
 * @property int      $expire_sec  The amount of time in seconds that may pass before this Domain is no longer
 *                                 authoritative (@see `TIME_...` constants).
 * @property string[] $master_ips  The IP addresses representing the master DNS for this Domain.
 * @property string[] $axfr_ips    The list of IPs that may perform a zone transfer for this Domain.
 *                                 This is potentially dangerous, and should be set to an empty list
 *                                 unless you intend to use it.
 * @property \Linode\Repository\Domains\DomainRecordRepositoryInterface $records Records of the domain.
 */
class Domain extends Entity
{
    // Available fields.
    public const FIELD_ID          = 'id';
    public const FIELD_DOMAIN      = 'domain';
    public const FIELD_TYPE        = 'type';
    public const FIELD_STATUS      = 'status';
    public const FIELD_SOA_EMAIL   = 'soa_email';
    public const FIELD_GROUP       = 'group';
    public const FIELD_DESCRIPTION = 'description';
    public const FIELD_TTL_SEC     = 'ttl_sec';
    public const FIELD_REFRESH_SEC = 'refresh_sec';
    public const FIELD_RETRY_SEC   = 'retry_sec';
    public const FIELD_EXPIRE_SEC  = 'expire_sec';
    public const FIELD_MASTER_IPS  = 'master_ips';
    public const FIELD_AXFR_IPS    = 'axfr_ips';

    // Domain types.
    public const TYPE_MASTER = 'master';
    public const TYPE_SLAVE  = 'slave';

    // Domain statuses.
    public const STATUS_DISABLED   = 'disabled';
    public const STATUS_ACTIVE     = 'active';
    public const STATUS_EDIT_MODE  = 'edit_mode';
    public const STATUS_HAS_ERRORS = 'has_errors';

    // Time values.
    public const TIME_5_MINS   = 300;
    public const TIME_1_HOUR   = 3600;
    public const TIME_2_HOURS  = 7200;
    public const TIME_4_HOURS  = 14400;
    public const TIME_8_HOURS  = 28800;
    public const TIME_16_HOURS = 57600;
    public const TIME_1_DAY    = 86400;
    public const TIME_2_DAYS   = 172800;
    public const TIME_4_DAYS   = 345600;
    public const TIME_1_WEEK   = 604800;
    public const TIME_2_WEEKS  = 1209600;
    public const TIME_4_WEEKS  = 2419200;

    /**
     * {@inheritdoc}
     */
    public function __get(string $name)
    {
        if ($name === 'records') {
            return new DomainRecordRepository($this->client, $this->id);
        }

        return parent::__get($name);
    }
}
