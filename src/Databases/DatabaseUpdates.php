<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Databases;

use Linode\Entity;

/**
 * Configuration settings for automated patch update maintenance for the Managed Database.
 *
 * @property string $frequency     Whether maintenance occurs on a weekly or monthly basis.
 * @property int    $duration      The maximum maintenance window time in hours.
 * @property int    $hour_of_day   The hour to begin maintenance based in UTC time.
 * @property int    $day_of_week   The day to perform maintenance. 1=Monday, 2=Tuesday, etc.
 * @property int    $week_of_month The week of the month to perform `monthly` frequency updates.
 */
class DatabaseUpdates extends Entity
{
    public const FREQUENCY_WEEKLY  = 'weekly';
    public const FREQUENCY_MONTHLY = 'monthly';
}
