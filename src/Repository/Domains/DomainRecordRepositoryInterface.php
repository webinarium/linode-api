<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Repository\Domains;

use Linode\Entity\Domains\DomainRecord;
use Linode\Exception\LinodeException;
use Linode\Repository\RepositoryInterface;

/**
 * Domain record repository.
 */
interface DomainRecordRepositoryInterface extends RepositoryInterface
{
    /**
     * Adds a new Domain Record to the zonefile this Domain represents.
     *
     * @throws LinodeException
     */
    public function create(array $parameters): DomainRecord;

    /**
     * Updates a single Record on this Domain.
     *
     * @throws LinodeException
     */
    public function update(int $id, array $parameters): DomainRecord;

    /**
     * Deletes a Record on this Domain.
     *
     * @throws LinodeException
     */
    public function delete(int $id): void;
}
