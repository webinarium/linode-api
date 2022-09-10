<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Repository\Domains;

use Linode\Entity\Domains\DomainRecord;
use Linode\Repository\RepositoryInterface;

/**
 * Domain record repository.
 */
interface DomainRecordRepositoryInterface extends RepositoryInterface
{
    /**
     * Adds a new Domain Record to the zonefile this Domain represents.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function create(array $parameters): DomainRecord;

    /**
     * Updates a single Record on this Domain.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function update(int $id, array $parameters): DomainRecord;

    /**
     * Deletes a Record on this Domain.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function delete(int $id): void;
}
