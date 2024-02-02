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
 * Managed Database engine object.
 *
 * @property string $id      The Managed Database engine ID in engine/version format.
 * @property string $engine  The Managed Database engine type.
 * @property string $version The Managed Database engine version.
 */
class DatabaseEngine extends Entity
{
    // Available fields.
    public const FIELD_ID      = 'id';
    public const FIELD_ENGINE  = 'engine';
    public const FIELD_VERSION = 'version';
}
