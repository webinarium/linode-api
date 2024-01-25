<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Managed;

use Linode\Exception\LinodeException;
use Linode\RepositoryInterface;

/**
 * Managed contact repository.
 */
interface ManagedContactRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a Managed Contact.  A Managed Contact is someone Linode
     * special forces can contact in the course of attempting to resolve an issue
     * with a Managed Service.
     *
     * @throws LinodeException
     */
    public function create(array $parameters): ManagedContact;

    /**
     * Updates information about a Managed Contact.
     *
     * @throws LinodeException
     */
    public function update(int $id, array $parameters): ManagedContact;

    /**
     * Deletes a Managed Contact.
     *
     * @throws LinodeException
     */
    public function delete(int $id): void;
}
