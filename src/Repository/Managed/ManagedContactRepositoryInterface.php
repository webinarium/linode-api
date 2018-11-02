<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Repository\Managed;

use Linode\Entity\Managed\ManagedContact;
use Linode\Repository\RepositoryInterface;

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
     * @param array $parameters
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return ManagedContact
     */
    public function create(array $parameters): ManagedContact;

    /**
     * Updates information about a Managed Contact.
     *
     * @param int   $id
     * @param array $parameters
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return ManagedContact
     */
    public function update(int $id, array $parameters): ManagedContact;

    /**
     * Deletes a Managed Contact.
     *
     * @param int $id
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function delete(int $id): void;
}
