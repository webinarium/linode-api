<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Repository\Account;

use Linode\Repository\RepositoryInterface;

/**
 * Event repository.
 */
interface EventRepositoryInterface extends RepositoryInterface
{
    /**
     * Marks all Events up to and including this Event by ID as seen.
     *
     * @param int $id The ID of the Event to designate as seen.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function markAsSeen(int $id): void;

    /**
     * Marks a single Event as read.
     *
     * @param int $id The ID of the Event to designate as read.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function markAsRead(int $id): void;
}
