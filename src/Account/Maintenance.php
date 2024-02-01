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
use Linode\Linode\LinodeEntity;

/**
 * Information about maintenance affecting an entity.
 *
 * @property string       $type   The type of maintenance.
 * @property string       $status The maintenance status.
 * @property string       $reason The reason maintenance is being performed.
 * @property string       $when   When the maintenance will begin.
 * @property LinodeEntity $entity The entity being affected by maintenance.
 */
class Maintenance extends Entity
{
    // Available fields.
    public const FIELD_TYPE   = 'type';
    public const FIELD_STATUS = 'status';
    public const FIELD_REASON = 'reason';
    public const FIELD_WHEN   = 'when';
    public const FIELD_ENTITY = 'entity';

    // `FIELD_TYPE` values.
    public const TYPE_REBOOT         = 'reboot';
    public const TYPE_COLD_MIGRATION = 'cold_migration';
    public const TYPE_LIVE_MIGRATION = 'live_migration';

    // `FIELD_STATUS` values.
    public const STATUS_PENDING   = 'pending';
    public const STATUS_READY     = 'ready';
    public const STATUS_STARTED   = 'started';
    public const STATUS_COMPLETED = 'completed';
}
