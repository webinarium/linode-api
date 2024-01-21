<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity\Profile;

use Linode\Entity\Entity;

/**
 * An application you have authorized access to your Account through OAuth.
 *
 * @property int    $id                 The unique ID for this TrustedDevice.
 * @property string $created            When this Remember Me session was started. This corresponds to the time of login
 *                                      with the "Remember Me" box checked.
 * @property string $expiry             When this TrustedDevice session expires. Sessions typically last 30 days.
 * @property string $user_agent         The User Agent of the browser that created this TrustedDevice session.
 * @property string $last_authenticated The last time this TrustedDevice was successfully used to authenticate to
 *                                      login.linode.com.
 * @property string $last_remote_addr   The last IP Address to successfully authenticate with this TrustedDevice.
 */
class TrustedDevice extends Entity
{
    // Available fields.
    public const FIELD_ID                 = 'id';
    public const FIELD_CREATED            = 'created';
    public const FIELD_EXPIRY             = 'expiry';
    public const FIELD_USER_AGENT         = 'user_agent';
    public const FIELD_LAST_AUTHENTICATED = 'last_authenticated';
    public const FIELD_LAST_REMOTE_ADDR   = 'last_remote_addr';
}
