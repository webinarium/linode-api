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
 * Represents the level of access a restricted User has to a specific resource on the
 * Account.
 *
 * @property int         $id          The ID of the entity this grant applies to.
 * @property string      $label       The current label of the entity this grant applies to, for display purposes.
 * @property null|string $permissions The level of access this User has to this entity. If null, this User has no
 *                                    access.
 */
class Grant extends Entity
{
    // Available fields.
    public const FIELD_ID          = 'id';
    public const FIELD_LABEL       = 'label';
    public const FIELD_PERMISSIONS = 'permissions';

    // `FIELD_PERMISSIONS` values.
    public const PERMISSIONS_READ_ONLY  = 'read_only';
    public const PERMISSIONS_READ_WRITE = 'read_write';
}
