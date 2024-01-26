<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Domains;

use Linode\Exception\LinodeException;
use Linode\RepositoryInterface;

/**
 * DomainRecord repository.
 *
 * @method DomainRecord   find(int|string $id)
 * @method DomainRecord[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method DomainRecord[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method DomainRecord   findOneBy(array $criteria)
 * @method DomainRecord[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface DomainRecordRepositoryInterface extends RepositoryInterface
{
    /**
     * Adds a new Domain Record to the zonefile this Domain represents.
     *
     * @param array $parameters Information about the new Record to add.
     *
     * @throws LinodeException
     */
    public function createDomainRecord(array $parameters = []): DomainRecord;

    /**
     * Updates a single Record on this Domain.
     *
     * @param int   $recordId   The ID of the Record you are accessing.
     * @param array $parameters The values to change.
     *
     * @throws LinodeException
     */
    public function updateDomainRecord(int $recordId, array $parameters = []): DomainRecord;

    /**
     * Deletes a Record on this Domain.
     *
     * @param int $recordId The ID of the Record you are accessing.
     *
     * @throws LinodeException
     */
    public function deleteDomainRecord(int $recordId): void;
}
