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
 * Account Settings object.
 *
 * @property bool   $network_helper        Enables network helper across all users by default for new Linodes and Linode
 *                                         Configs.
 * @property string $longview_subscription The Longview Pro tier you are currently subscribed to. The value must a Longview
 *                                         Subscription ID or `null`.
 * @property bool   $managed               Our 24/7 incident response service. This robust, multi-homed monitoring system
 *                                         distributes monitoring checks to ensure that your servers remain online and
 *                                         available at all times. Linode Managed can monitor any service or software stack
 *                                         reachable over TCP or HTTP. Once you add a service to Linode Managed, we'll
 *                                         monitor it for connectivity, response, and total request time.
 * @property bool   $backups_enabled       Account-wide backups default. If `true`, all Linodes created will automatically be
 *                                         enrolled in the Backups service. If `false`, Linodes will not be enrolled by
 *                                         default, but may still be enrolled on creation or later.
 * @property string $object_storage        A string describing the status of this account's Object Storage service
 *                                         enrollment.
 */
class AccountSettings extends Entity
{
    // Available fields.
    public const FIELD_NETWORK_HELPER        = 'network_helper';
    public const FIELD_LONGVIEW_SUBSCRIPTION = 'longview_subscription';
    public const FIELD_MANAGED               = 'managed';
    public const FIELD_BACKUPS_ENABLED       = 'backups_enabled';
    public const FIELD_OBJECT_STORAGE        = 'object_storage';

    // `FIELD_OBJECT_STORAGE` values.
    public const OBJECT_STORAGE_DISABLED  = 'disabled';
    public const OBJECT_STORAGE_SUSPENDED = 'suspended';
    public const OBJECT_STORAGE_ACTIVE    = 'active';
}
