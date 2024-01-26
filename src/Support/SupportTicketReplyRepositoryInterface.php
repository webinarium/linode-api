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
 * SupportTicketReply repository.
 *
 * @method SupportTicketReply   find(int|string $id)
 * @method SupportTicketReply[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method SupportTicketReply[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method SupportTicketReply   findOneBy(array $criteria)
 * @method SupportTicketReply[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface SupportTicketReplyRepositoryInterface extends RepositoryInterface
{
    /**
     * Adds a reply to an existing Support Ticket.
     *
     * @param array $parameters Add a reply.
     *
     * @throws LinodeException
     */
    public function createTicketReply(array $parameters = []): SupportTicketReply;
}
