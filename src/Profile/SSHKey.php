<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Profile;

use Linode\Entity;

/**
 * A credential object for authenticating a User's secure shell connection to a Linode.
 *
 * @property int    $id      The unique identifier of an SSH Key object.
 * @property string $label   A label for the SSH Key.
 * @property string $ssh_key The public SSH Key, which is used to authenticate to the root user
 *                           of the Linodes you deploy.
 * @property string $created The date this key was added.
 */
class SSHKey extends Entity
{
    // Available fields.
    public const FIELD_ID      = 'id';
    public const FIELD_LABEL   = 'label';
    public const FIELD_SSH_KEY = 'ssh_key';
    public const FIELD_CREATED = 'created';
}
