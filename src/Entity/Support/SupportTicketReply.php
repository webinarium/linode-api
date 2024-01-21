<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity\Support;

use Linode\Entity\Entity;

/**
 * An object representing a reply to a Support Ticket.
 *
 * @property int    $id          The unique ID of this Support Ticket reply.
 * @property string $created_by  The User who submitted this reply.
 * @property string $created     The date and time this Ticket reply was created.
 * @property string $description The body of this Support Ticket reply.
 * @property string $gravatar_id The Gravatar ID of the User who created this reply.
 * @property bool   $from_linode If set to true, this reply came from a Linode employee.
 */
class SupportTicketReply extends Entity
{
    // Available fields.
    public const FIELD_ID          = 'id';
    public const FIELD_CREATED_BY  = 'created_by';
    public const FIELD_CREATED     = 'created';
    public const FIELD_DESCRIPTION = 'description';
    public const FIELD_GRAVATAR_ID = 'gravatar_id';
    public const FIELD_FROM_LINODE = 'from_linode';
}
