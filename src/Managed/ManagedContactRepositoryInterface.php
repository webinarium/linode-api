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
 * ManagedContact repository.
 *
 * @method ManagedContact   find(int|string $id)
 * @method ManagedContact[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method ManagedContact[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method ManagedContact   findOneBy(array $criteria)
 * @method ManagedContact[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface ManagedContactRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a Managed Contact. A Managed Contact is someone Linode
     * special forces can contact in the course of attempting to resolve an issue
     * with a Managed Service.
     *
     * This command can only be accessed by the unrestricted users of an account.
     *
     * @param array $parameters Information about the contact to create.
     *
     * @throws LinodeException
     */
    public function createManagedContact(array $parameters = []): ManagedContact;

    /**
     * Updates information about a Managed Contact.
     * This command can only be accessed by the unrestricted users of an account.
     *
     * @param int   $contactId  The ID of the contact to access.
     * @param array $parameters The fields to update.
     *
     * @throws LinodeException
     */
    public function updateManagedContact(int $contactId, array $parameters = []): ManagedContact;

    /**
     * Deletes a Managed Contact.
     *
     * This command can only be accessed by the unrestricted users of an account.
     *
     * @param int $contactId The ID of the contact to access.
     *
     * @throws LinodeException
     */
    public function deleteManagedContact(int $contactId): void;
}
