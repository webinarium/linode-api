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
 */
interface EventRepositoryInterface extends RepositoryInterface
{
    /**
     * Marks all Events up to and including this Event by ID as seen.
     *
     * @param int $id the ID of the Event to designate as seen
     *
     * @throws LinodeException
     */
    public function markAsSeen(int $id): void;

    /**
     * Marks a single Event as read.
     *
     * @param int $id the ID of the Event to designate as read
     *
     * @throws LinodeException
     */
    public function markAsRead(int $id): void;
}
