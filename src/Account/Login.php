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
 * An object representing a previous successful login for a User.
 *
 * @property int    $id         The unique ID of this login object.
 * @property string $datetime   When the login was initiated.
 * @property string $ip         The remote IP address that requested the login.
 * @property string $username   The username of the User that attempted the login.
 * @property string $status     Whether the login attempt succeeded or failed.
 * @property bool   $restricted True if the User that attempted the login was a restricted User, false otherwise.
 */
class Login extends Entity
{
    // Available fields.
    public const FIELD_ID         = 'id';
    public const FIELD_DATETIME   = 'datetime';
    public const FIELD_IP         = 'ip';
    public const FIELD_USERNAME   = 'username';
    public const FIELD_STATUS     = 'status';
    public const FIELD_RESTRICTED = 'restricted';

    // `FIELD_STATUS` values.
    public const STATUS_SUCCESSFUL = 'successful';
    public const STATUS_FAILED     = 'failed';
}
