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

use Linode\Entity\Support\SupportTicket;
use Linode\Repository\RepositoryInterface;

/**
 * Support ticket repository.
 */
interface SupportTicketRepositoryInterface extends RepositoryInterface
{
    /**
     * Open a Support Ticket.
     *
     * Only one of the ID attributes (`linode_id`, `domain_id`, etc.) can be set
     * on a single Support Ticket.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function open(array $parameters): SupportTicket;

    /**
     * Closes a Support Ticket you have access to modify.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function close(int $id): void;
}
