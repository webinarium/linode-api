<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity\Account;

use Linode\Entity\Entity;

/**
 * Represents the level of access a restricted User has to a specific resource on the Account.
 *
 * @property int         $id          The ID of the entity this grant applies to.
 * @property string      $label       The current label of the entity this grant applies to, for display purposes.
 * @property null|string $permissions The level of access this User has to this entity.
 *                                    If null, this User has no access (@see permissions constants below).
 */
class Grant extends Entity
{
    // Available fields.
    public const FIELD_ID          = 'id';
    public const FIELD_LABEL       = 'label';
    public const FIELD_PERMISSIONS = 'permissions';

    // Permissions.
    public const NO_ACCESS         = null;
    public const ACCESS_READ_ONLY  = 'read_only';
    public const ACCESS_READ_WRITE = 'read_write';
}
