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
 * A database backup object.
 *
 * @property int    $id      The ID of the database backup object.
 * @property string $label   The database backup's label, for display purposes only.
 *                           Must include only ASCII letters or numbers.
 * @property string $type    The type of database backup, determined by how the backup was created.
 * @property string $created A time value given in a combined date and time format that represents when the
 *                           database backup was created.
 */
class DatabaseBackup extends Entity
{
    // Available fields.
    public const FIELD_ID      = 'id';
    public const FIELD_LABEL   = 'label';
    public const FIELD_TYPE    = 'type';
    public const FIELD_CREATED = 'created';

    // `FIELD_TYPE` values.
    public const TYPE_SNAPSHOT = 'snapshot';
    public const TYPE_AUTO     = 'auto';
}
