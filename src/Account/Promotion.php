<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Account;

use Linode\Entity;

/**
 * Promotions generally
 * offer a set amount of credit that can be used toward your Linode
 * services, and the promotion expires after a specified date. As well,
 * a monthly cap on the promotional offer is set.
 *
 * Simply put, a promotion offers a certain amount of credit every
 * month, until either the expiration date is passed, or until the total
 * promotional credit is used, whichever comes first.
 *
 * @property string $service_type                The service to which this promotion applies.
 * @property string $expire_dt                   When this promotion's credits expire.
 * @property string $credit_remaining            The total amount of credit left for this promotion.
 * @property string $this_month_credit_remaining The amount of credit left for this month for this promotion.
 * @property string $credit_monthly_cap          The amount available to spend per month.
 * @property string $summary                     Short details of this promotion.
 * @property string $description                 A detailed description of this promotion.
 * @property string $image_url                   The location of an image for this promotion.
 */
class Promotion extends Entity
{
    // Available fields.
    public const FIELD_SERVICE_TYPE                = 'service_type';
    public const FIELD_EXPIRE_DT                   = 'expire_dt';
    public const FIELD_CREDIT_REMAINING            = 'credit_remaining';
    public const FIELD_THIS_MONTH_CREDIT_REMAINING = 'this_month_credit_remaining';
    public const FIELD_CREDIT_MONTHLY_CAP          = 'credit_monthly_cap';
    public const FIELD_SUMMARY                     = 'summary';
    public const FIELD_DESCRIPTION                 = 'description';
    public const FIELD_IMAGE_URL                   = 'image_url';

    // `FIELD_SERVICE_TYPE` values.
    public const SERVICE_TYPE_ALL           = 'all';
    public const SERVICE_TYPE_BACKUP        = 'backup';
    public const SERVICE_TYPE_BLOCKSTORAGE  = 'blockstorage';
    public const SERVICE_TYPE_DB_MYSQL      = 'db_mysql';
    public const SERVICE_TYPE_IP_V4         = 'ip_v4';
    public const SERVICE_TYPE_LINODE        = 'linode';
    public const SERVICE_TYPE_LINODE_DISK   = 'linode_disk';
    public const SERVICE_TYPE_LINODE_MEMORY = 'linode_memory';
    public const SERVICE_TYPE_LONGVIEW      = 'longview';
    public const SERVICE_TYPE_MANAGED       = 'managed';
    public const SERVICE_TYPE_NODEBALANCER  = 'nodebalancer';
    public const SERVICE_TYPE_OBJECTSTORAGE = 'objectstorage';
    public const SERVICE_TYPE_TRANSFER_TX   = 'transfer_tx';
}
