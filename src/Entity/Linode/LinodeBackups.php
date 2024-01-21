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
 * Information about this Linode's backups status.
 *
 * @property bool                 $enabled  If this Linode has the Backup service enabled.
 * @property LinodeBackupSchedule $schedule Information about this Linode's backups schedule.
 */
class LinodeBackups extends Entity
{
    // Available fields.
    public const FIELD_SCHEDULE = 'schedule';

    public function __get(string $name): mixed
    {
        return match ($name) {
            self::FIELD_SCHEDULE => new LinodeBackupSchedule($this->client, $this->data[self::FIELD_SCHEDULE]),
            default              => parent::__get($name),
        };
    }
}
