<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Support;

use Linode\Exception\LinodeException;
use Linode\RepositoryInterface;

/**
 * Support ticket reply repository.
 */
interface SupportTicketReplyRepositoryInterface extends RepositoryInterface
{
    /**
     * Adds a reply to an existing Support Ticket.
     *
     * @throws LinodeException
     */
    public function create(array $parameters): SupportTicketReply;
}
