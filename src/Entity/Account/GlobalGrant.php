<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity\Account;

use Linode\Entity\Entity;

/**
 * A structure containing the Account-level grants a User has.
 *
 * @property null|string $account_access        The level of access this User has to Account-level actions,
 *                                              like billing information. A restricted User will never be able
 *                                              to manage users (@see permissions constants below).
 * @property bool        $cancel_account        If `true`, this User may cancel the entire Account.
 * @property bool        $longview_subscription If `true`, this User may manage the Account's Longview subscription.
 * @property bool        $add_domains           If `true`, this User may add Domains.
 * @property bool        $add_images            If `true`, this User may add Images.
 * @property bool        $add_linodes           If `true`, this User may create Linodes.
 * @property bool        $add_longview          If `true`, this User may create Longview clients.
 * @property bool        $add_nodebalancers     If `true`, this User may add NodeBalancers.
 * @property bool        $add_stackscripts      If `true`, this User may add StackScripts.
 * @property bool        $add_volumes           If `true`, this User may add Volumes.
 */
class GlobalGrant extends Entity
{
    // Available fields.
    public const FIELD_ADD_LINODES           = 'add_linodes';
    public const FIELD_ADD_LONGVIEW          = 'add_longview';
    public const FIELD_LONGVIEW_SUBSCRIPTION = 'longview_subscription';
    public const FIELD_ACCOUNT_ACCESS        = 'account_access';
    public const FIELD_CANCEL_ACCOUNT        = 'cancel_account';
    public const FIELD_ADD_DOMAINS           = 'add_domains';
    public const FIELD_ADD_STACKSCRIPTS      = 'add_stackscripts';
    public const FIELD_ADD_NODEBALANCERS     = 'add_nodebalancers';
    public const FIELD_ADD_IMAGES            = 'add_images';
    public const FIELD_ADD_VOLUMES           = 'add_volumes';

    // Permissions.
    public const NO_ACCESS         = null;
    public const ACCESS_READ_ONLY  = 'read_only';
    public const ACCESS_READ_WRITE = 'read_write';
}
