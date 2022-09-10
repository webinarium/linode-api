<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity\Support;

use Linode\Entity\Entity;
use Linode\Entity\LinodeEntity;
use Linode\Internal\Support\SupportTicketReplyRepository;

/**
 * A Support Ticket opened on your Account.
 *
 * @property int                                                              $id          The ID of the Support Ticket.
 * @property string                                                           $summary     The summary or title for this Ticket.
 * @property string                                                           $opened_by   The User who opened this Ticket.
 * @property string                                                           $opened      The date and time this Ticket was created.
 * @property string                                                           $description The full details of the issue or question.
 * @property LinodeEntity                                                     $entity      The entity this Ticket was opened for.
 * @property string                                                           $gravatar_id The Gravatar ID of the User who opened this Ticket.
 * @property string                                                           $status      The current status of this Ticket (@see `STATUS_...` constants).
 * @property bool                                                             $closable    Whether the Support Ticket may be closed.
 * @property string[]                                                         $attachments A list of filenames representing attached files associated
 *                                                                                         with this Ticket.
 * @property string                                                           $updated_by  The User who last updated this Ticket.
 * @property string                                                           $updated     The date and time this Ticket was last updated.
 * @property string                                                           $closed      The date and time this Ticket was closed.
 * @property \Linode\Repository\Support\SupportTicketReplyRepositoryInterface $replies     Replies to the ticket.
 */
class SupportTicket extends Entity
{
    // Available fields.
    public const FIELD_ID          = 'id';
    public const FIELD_SUMMARY     = 'summary';
    public const FIELD_OPENED_BY   = 'opened_by';
    public const FIELD_OPENED      = 'opened';
    public const FIELD_DESCRIPTION = 'description';
    public const FIELD_GRAVATAR_ID = 'gravatar_id';
    public const FIELD_STATUS      = 'status';
    public const FIELD_CLOSABLE    = 'closable';
    public const FIELD_UPDATED_BY  = 'updated_by';
    public const FIELD_UPDATED     = 'updated';
    public const FIELD_CLOSED      = 'closed';

    // Extra field for create/update operations.
    public const FIELD_DOMAIN_ID         = 'domain_id';
    public const FIELD_LINODE_ID         = 'linode_id';
    public const FIELD_LONGVIEWCLIENT_ID = 'longviewclient_id';
    public const FIELD_NODEBALANCER_ID   = 'nodebalancer_id';
    public const FIELD_VOLUME_ID         = 'volume_id';

    // Ticket statuses.
    public const STATUS_NEW    = 'new';
    public const STATUS_OPEN   = 'open';
    public const STATUS_CLOSED = 'closed';

    /**
     * {@inheritdoc}
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'entity'  => new LinodeEntity($this->client, $this->data[$name]),
            'replies' => new SupportTicketReplyRepository($this->client, $this->id),
            default   => parent::__get($name),
        };
    }
}
