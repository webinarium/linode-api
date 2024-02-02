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
 * Managed Database object for database credentials.
 *
 * @property string $username The root username for the Managed Database instance.
 * @property string $password The randomly-generated root password for the Managed Database instance.
 */
class DatabaseCredentials extends Entity
{
    // Available fields.
    public const FIELD_USERNAME = 'username';
    public const FIELD_PASSWORD = 'password';
}
