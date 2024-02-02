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
 * An object representing a Service Transfer.
 *
 * @property string $token     The token used to identify and accept or cancel this transfer.
 * @property string $status    The status of the transfer request.
 *                             `accepted`: The transfer has been accepted by another user and is currently in
 *                             progress.
 *                             Transfers can take up to 3 hours to complete.
 *                             `canceled`: The transfer has been canceled by the sender.
 *                             `completed`: The transfer has completed successfully.
 *                             `failed`: The transfer has failed after initiation.
 *                             `pending`: The transfer is ready to be accepted.
 *                             `stale`: The transfer has exceeded its expiration date. It can no longer be
 *                             accepted or
 *                             canceled.
 * @property string $expiry    When this transfer expires. Transfers will automatically expire 24 hours after
 *                             creation.
 * @property bool   $is_sender If the requesting account created this transfer.
 * @property string $created   When this transfer was created.
 * @property string $updated   When this transfer was last updated.
 * @property object $entities  A collection of the services to include in this transfer request, separated by
 *                             type.
 */
class ServiceTransfer extends Entity
{
    // Available fields.
    public const FIELD_TOKEN     = 'token';
    public const FIELD_STATUS    = 'status';
    public const FIELD_EXPIRY    = 'expiry';
    public const FIELD_IS_SENDER = 'is_sender';
    public const FIELD_CREATED   = 'created';
    public const FIELD_UPDATED   = 'updated';
    public const FIELD_ENTITIES  = 'entities';

    // `FIELD_STATUS` values.
    public const STATUS_ACCEPTED  = 'accepted';
    public const STATUS_CANCELED  = 'canceled';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED    = 'failed';
    public const STATUS_PENDING   = 'pending';
    public const STATUS_STALE     = 'stale';
}
