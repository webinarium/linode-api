<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity\Linode;

use Linode\Entity\Entity;

/**
 * Information about Linode's backups schedule.
 *
 * @property string $day    The day of the week that your Linode's weekly Backup is taken.
 *                          If not set manually, a day will be chosen for you. Backups
 *                          are taken every day, but backups taken on this day are
 *                          preferred when selecting backups to retain for a longer period.
 *                          If not set manually, then when backups are initially enabled, this
 *                          may come back as `Scheduling` until the `day` is automatically
 *                          selected (@see `DAY_...` constants).
 * @property string $window The window in which your backups will be taken, in UTC. A
 *                          backups window is a two-hour span of time in which the backup
 *                          may occur.
 *                          For example, `W10` indicates that your backups should be
 *                          taken between 10:00 and 12:00. If you do not choose a backup
 *                          window, one will be selected for you automatically.
 *                          If not set manually, when backups are initially enabled this
 *                          may come back as `Scheduling` until the `window` is automatically
 *                          selected (@see `WINDOW_...` constants).
 */
class LinodeBackupSchedule extends Entity
{
    // Available fields.
    public const FIELD_DAY    = 'day';
    public const FIELD_WINDOW = 'window';

    // Backup days.
    public const DAY_SCHEDULING = 'Scheduling';
    public const DAY_SUNDAY     = 'Sunday';
    public const DAY_MONDAY     = 'Monday';
    public const DAY_TUESDAY    = 'Tuesday';
    public const DAY_WEDNESDAY  = 'Wednesday';
    public const DAY_THURSDAY   = 'Thursday';
    public const DAY_FRIDAY     = 'Friday';
    public const DAY_SATURDAY   = 'Saturday';

    // Backup windows.
    public const WINDOW_SCHEDULING = 'Scheduling';
    public const WINDOW_W0         = 'W0';
    public const WINDOW_W2         = 'W2';
    public const WINDOW_W4         = 'W4';
    public const WINDOW_W6         = 'W6';
    public const WINDOW_W8         = 'W8';
    public const WINDOW_W10        = 'W10';
    public const WINDOW_W12        = 'W12';
    public const WINDOW_W14        = 'W14';
    public const WINDOW_W16        = 'W16';
    public const WINDOW_W18        = 'W18';
    public const WINDOW_W20        = 'W20';
    public const WINDOW_W22        = 'W22';
}
