<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity\Managed;

use Linode\Entity\Entity;

/**
 * An entity related to an Issue.
 *
 * @property int    $id    This entity's ID.
 * @property string $type  The type of entity this is. In this case, it is always a Ticket (@see `TYPE_...` constants).
 * @property string $label The summary for this Ticket.
 * @property string $url   The relative URL where you can access this Ticket.
 */
class ManagedIssueEntity extends Entity
{
    // Types.
    public const TYPE_TICKET = 'ticket';
}
