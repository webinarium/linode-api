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

use Linode\Exception\LinodeException;
use Linode\RepositoryInterface;

/**
 * Event repository.
 *
 * @method Event   find(int|string $id)
 * @method Event[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Event[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Event   findOneBy(array $criteria)
 * @method Event[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface EventRepositoryInterface extends RepositoryInterface
{
    /**
     * Marks a single Event as read.
     *
     * @param int $eventId The ID of the Event to designate as read.
     *
     * @throws LinodeException
     */
    public function eventRead(int $eventId): void;

    /**
     * Marks all Events up to and including this Event by ID as seen.
     *
     * @param int $eventId The ID of the Event to designate as seen.
     *
     * @throws LinodeException
     */
    public function eventSeen(int $eventId): void;
}
