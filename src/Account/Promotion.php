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
 * Promotions generally offer a set amount of credit that can be used toward
 * your Linode services, and the promotion expires after a specified date.
 * As well, a monthly cap on the promotional offer is set.
 *
 * Simply put, a promotion offers a certain amount of credit every month,
 * until either the expiration date is passed, or until the total promotional
 * credit is used, whichever comes first.
 *
 * @property string $expire_dt                   When this promotion's credits expire.
 * @property string $credit_remaining            The total amount of credit left for this promotion.
 * @property string $this_month_credit_remaining The amount of credit left for this month for this promotion.
 * @property string $credit_monthly_cap          The amount available to spend per month.
 * @property string $summary                     Short details of this promotion.
 * @property string $image_url                   The location of an image for this promotion.
 * @property string $description                 A detailed description of this promotion.
 */
class Promotion extends Entity {}
