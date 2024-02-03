<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\LinodeInstances;

use Linode\Exception\LinodeException;
use Linode\RepositoryInterface;

/**
 * LinodeConfig repository.
 *
 * @method LinodeConfig   find(int|string $id)
 * @method LinodeConfig[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method LinodeConfig[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method LinodeConfig   findOneBy(array $criteria)
 * @method LinodeConfig[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface LinodeConfigRepositoryInterface extends RepositoryInterface
{
    /**
     * Adds a new Configuration profile to a Linode.
     *
     * @param array $parameters The parameters to set when creating the Configuration profile.
     *                          This determines which kernel, devices, how much memory, etc. a Linode boots with.
     *
     * @throws LinodeException
     */
    public function addLinodeConfig(array $parameters = []): LinodeConfig;

    /**
     * Updates a Configuration profile.
     *
     * @param int   $configId   The `id` of the Configuration Profile.
     * @param array $parameters The Configuration profile parameters to modify.
     *
     * @throws LinodeException
     */
    public function updateLinodeConfig(int $configId, array $parameters = []): LinodeConfig;

    /**
     * Deletes the specified Configuration profile from the specified Linode.
     *
     * @param int $configId The `id` of the Configuration Profile.
     *
     * @throws LinodeException
     */
    public function deleteLinodeConfig(int $configId): void;

    /**
     * Returns an ordered array of all Interfaces associated with this Configuration
     * Profile.
     * * The User accessing this command must have at least `read_only` grants to the
     * Linode.
     *
     * @param int $configId The `id` of the Configuration Profile.
     *
     * @return LinodeConfigInterface[] An ordered array of Interface objects.
     *
     * @throws LinodeException
     */
    public function getLinodeConfigInterfaces(int $configId): array;

    /**
     * Returns a single Configuration Profile Interface.
     * * The User accessing this command must have at least `read_only` grants to the
     * Linode.
     *
     * @param int $configId    The `id` of the Configuration Profile.
     * @param int $interfaceId The `id` of the Linode Configuration Profile Interface.
     *
     * @throws LinodeException
     */
    public function getLinodeConfigInterface(int $configId, int $interfaceId): LinodeConfigInterface;

    /**
     * Creates and appends a single Interface to the end of the `interfaces` array for an
     * existing Configuration Profile.
     * * The User accessing this command must have `read_write` grants to the Linode.
     * * A successful request triggers a `linode_config_update` event.
     * * If the new Interface is added with `"primary": true`, then any existing primary
     * Interface is changed to `"primary": false`.
     *
     * Reboot the Linode with this Configuration Profile to activate an Interface that
     * was added with this command.
     *
     * @param int   $configId   The `id` of the Configuration Profile.
     * @param array $parameters The Interface to add to the Configuration Profile.
     *
     * @throws LinodeException
     */
    public function addLinodeConfigInterface(int $configId, array $parameters = []): LinodeConfigInterface;

    /**
     * Updates a `vpc` or `public` purpose Interface for this Configuration Profile.
     * * The User accessing this command must have `read_write` grants to the Linode.
     * * A successful request triggers a `linode_config_update` event.
     * * The Interface `purpose` cannot be updated with this command.
     * * VPC Subnets cannot be updated on an Interface. A new `vpc` purpose Interface
     * must be created to assign a different Subnet to a Configuration Profile.
     * * Only `primary` can be updated for `public` purpose Interfaces.
     * * This command not currently allowed for `vlan` purpose Interfaces.
     *
     * @param int   $configId    The `id` of the Configuration Profile.
     * @param int   $interfaceId The `id` of the Linode Configuration Profile Interface.
     * @param array $parameters  The updated Interface.
     *
     * @throws LinodeException
     */
    public function updateLinodeConfigInterface(int $configId, int $interfaceId, array $parameters = []): LinodeConfigInterface;

    /**
     * Deletes an Interface from the Configuration Profile.
     *
     * * The User accessing this command must have `read_write` grants to the Linode.
     * * A successful request triggers a `linode_config_update` event.
     * * Active Interfaces cannot be deleted. The associated Linode must first be shut
     * down (or restarted using another Configuration Profile) before such Interfaces can
     * be deleted from a Configuration Profile.
     *
     * @param int $configId    The `id` of the Configuration Profile.
     * @param int $interfaceId The `id` of the Linode Configuration Profile Interface.
     *
     * @throws LinodeException
     */
    public function deleteLinodeConfigInterface(int $configId, int $interfaceId): void;

    /**
     * Reorders the existing Interfaces of a Configuration Profile.
     * * The User accessing this command must have `read_write` grants to the Linode.
     *
     * @param int   $configId   The `id` of the Configuration Profile.
     * @param array $parameters The desired Interface order for the Configuration Profile.
     *
     * @throws LinodeException
     */
    public function orderLinodeConfigInterfaces(int $configId, array $parameters = []): void;
}
