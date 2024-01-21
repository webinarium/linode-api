<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Repository\Support;

use Linode\Entity\Support\SupportTicketReply;
use Linode\Repository\RepositoryInterface;

/**
 * Support ticket reply repository.
 */
interface SupportTicketReplyRepositoryInterface extends RepositoryInterface
{
    /**
     * Adds a reply to an existing Support Ticket.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function create(array $parameters): SupportTicketReply;
}
