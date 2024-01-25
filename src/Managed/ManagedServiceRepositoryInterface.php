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
 * Managed service repository.
 */
interface ManagedServiceRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a Managed Service. Linode Managed will begin monitoring this
     * service and reporting and attempting to resolve any Issues.
     *
     * @throws LinodeException
     */
    public function create(array $parameters): ManagedService;

    /**
     * Updates information about a Managed Service.
     *
     * @throws LinodeException
     */
    public function update(int $id, array $parameters): ManagedService;

    /**
     * Deletes a Managed Service. This service will no longer be monitored by Linode Managed.
     *
     * @throws LinodeException
     */
    public function delete(int $id): void;

    /**
     * Temporarily disables monitoring of a Managed Service.
     *
     * @throws LinodeException
     */
    public function disable(int $id): ManagedService;

    /**
     * Enables monitoring of a Managed Service.
     *
     * @throws LinodeException
     */
    public function enable(int $id): ManagedService;

    /**
     * Returns the unique SSH public key assigned to your Linode account's
     * Managed service. If you add this public key to a Linode on your account,
     * Linode special forces will be able to log in to the Linode with this key
     * when attempting to resolve issues.
     *
     * @return string the unique SSH public key assigned to your Linode account's Managed service
     *
     * @throws LinodeException
     */
    public function getSshKey(): string;
}
