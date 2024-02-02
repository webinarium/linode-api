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
 * ManagedService repository.
 *
 * @method ManagedService   find(int|string $id)
 * @method ManagedService[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method ManagedService[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method ManagedService   findOneBy(array $criteria)
 * @method ManagedService[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface ManagedServiceRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a Managed Service. Linode Managed will begin monitoring this
     * service and reporting and attempting to resolve any Issues.
     *
     * This command can only be accessed by the unrestricted users of an account.
     *
     * @param array $parameters Information about the service to monitor.
     *
     * @throws LinodeException
     */
    public function createManagedService(array $parameters = []): ManagedService;

    /**
     * Updates information about a Managed Service.
     *
     * This command can only be accessed by the unrestricted users of an account.
     *
     * @param int   $serviceId  The ID of the Managed Service to access.
     * @param array $parameters The fields to update.
     *
     * @throws LinodeException
     */
    public function updateManagedService(int $serviceId, array $parameters = []): ManagedService;

    /**
     * Deletes a Managed Service. This service will no longer be monitored by
     * Linode Managed.
     *
     * This command can only be accessed by the unrestricted users of an account.
     *
     * @param int $serviceId The ID of the Managed Service to access.
     *
     * @throws LinodeException
     */
    public function deleteManagedService(int $serviceId): void;

    /**
     * Temporarily disables monitoring of a Managed Service.
     *
     * This command can only be accessed by the unrestricted users of an account.
     *
     * @param int $serviceId The ID of the Managed Service to disable.
     *
     * @throws LinodeException
     */
    public function disableManagedService(int $serviceId): ManagedService;

    /**
     * Enables monitoring of a Managed Service.
     *
     * This command can only be accessed by the unrestricted users of an account.
     *
     * @param int $serviceId The ID of the Managed Service to enable.
     *
     * @throws LinodeException
     */
    public function enableManagedService(int $serviceId): ManagedService;
}
