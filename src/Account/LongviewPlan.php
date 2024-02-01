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
 * Longview Plan object.
 *
 * @property null|string $longview_subscription The subscription ID for a particular Longview plan. A value of `null` corresponds
 *                                              to Longview Free.
 *                                              You can send a request to the List Longview Subscriptions endpoint to receive the
 *                                              details of each plan.
 */
class LongviewPlan extends Entity
{
    // Available fields.
    public const FIELD_LONGVIEW_SUBSCRIPTION = 'longview_subscription';

    // `FIELD_LONGVIEW_SUBSCRIPTION` values.
    public const LONGVIEW_SUBSCRIPTION_LONGVIEW_3   = 'longview-3';
    public const LONGVIEW_SUBSCRIPTION_LONGVIEW_10  = 'longview-10';
    public const LONGVIEW_SUBSCRIPTION_LONGVIEW_40  = 'longview-40';
    public const LONGVIEW_SUBSCRIPTION_LONGVIEW_100 = 'longview-100';
}
