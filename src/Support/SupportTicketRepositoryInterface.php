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
 * SupportTicket repository.
 *
 * @method SupportTicket   find(int|string $id)
 * @method SupportTicket[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method SupportTicket[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method SupportTicket   findOneBy(array $criteria)
 * @method SupportTicket[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface SupportTicketRepositoryInterface extends RepositoryInterface
{
    /**
     * Open a Support Ticket.
     * Only one of the ID attributes (`linode_id`, `domain_id`, etc.) can be set on a
     * single Support Ticket.
     *
     * @param array $parameters Open a Support Ticket.
     *
     * @throws LinodeException
     */
    public function createTicket(array $parameters = []): SupportTicket;

    /**
     * Adds a file attachment to an existing Support Ticket on your Account. File
     * attachments are used to assist our Support team in resolving your Ticket. Examples
     * of attachments are screen shots and text files that provide additional
     * information.
     * Note: Accepted file extensions include: .gif, .jpg, .jpeg, .pjpg, .pjpeg, .tif,
     * .tiff, .png, .pdf, or .txt.
     *
     * @param int    $ticketId The ID of the Support Ticket.
     * @param string $file     The local, absolute path to the file you want to attach to your Support Ticket.
     *
     * @throws LinodeException
     */
    public function createTicketAttachment(int $ticketId, string $file): void;

    /**
     * Closes a Support Ticket you have access to modify.
     *
     * @param int $ticketId The ID of the Support Ticket.
     *
     * @throws LinodeException
     */
    public function closeTicket(int $ticketId): void;
}
