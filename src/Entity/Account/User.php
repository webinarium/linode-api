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
 * A User on your Account. Unrestricted users can log in and access information about
 * your Account, while restricted users may only access entities or perform
 * actions they've been granted access to.
 *
 * @property string   $username   This User's username. This is used for logging in, and may also be
 *                                displayed alongside actions the User performs (for example, in Events
 *                                or public StackScripts).
 * @property string   $email      The email address for this User, for account management
 *                                communications, and may be used for other communications as configured.
 * @property bool     $restricted If true, this User must be granted access to perform actions or access
 *                                entities on this Account.
 * @property string[] $ssh_keys   A list of SSH Key labels added by this User. These are the keys
 *                                that will be deployed if this User is included in the `authorized_users`
 *                                field of a create Linode, rebuild Linode, or create Disk request.
 */
class User extends Entity
{
    // Available fields.
    public const FIELD_USERNAME   = 'username';
    public const FIELD_EMAIL      = 'email';
    public const FIELD_RESTRICTED = 'restricted';
    public const FIELD_SSH_KEYS   = 'ssh_keys';
}
