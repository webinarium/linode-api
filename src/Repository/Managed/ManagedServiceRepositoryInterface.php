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

use Linode\Entity\Managed\ManagedService;
use Linode\Repository\RepositoryInterface;

/**
 * Managed service repository.
 */
interface ManagedServiceRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a Managed Service. Linode Managed will being monitoring this
     * service and reporting and attempting to resolve any Issues.
     *
     * @param array $parameters
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return ManagedService
     */
    public function create(array $parameters): ManagedService;

    /**
     * Updates information about a Managed Service.
     *
     * @param int   $id
     * @param array $parameters
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return ManagedService
     */
    public function update(int $id, array $parameters): ManagedService;

    /**
     * Deletes a Managed Service. This service will no longer be monitored by Linode Managed.
     *
     * @param int $id
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function delete(int $id): void;

    /**
     * Temporarily disables monitoring of a Managed Service.
     *
     * @param int $id
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return ManagedService
     */
    public function disable(int $id): ManagedService;

    /**
     * Enables monitoring of a Managed Service.
     *
     * @param int $id
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return ManagedService
     */
    public function enable(int $id): ManagedService;
}
