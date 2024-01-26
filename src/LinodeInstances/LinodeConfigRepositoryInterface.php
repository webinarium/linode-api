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
     * @param int   $configId   The ID of the Configuration profile to look up.
     * @param array $parameters The Configuration profile parameters to modify.
     *
     * @throws LinodeException
     */
    public function updateLinodeConfig(int $configId, array $parameters = []): LinodeConfig;

    /**
     * Deletes the specified Configuration profile from the specified Linode.
     *
     * @param int $configId The ID of the Configuration profile to look up.
     *
     * @throws LinodeException
     */
    public function deleteLinodeConfig(int $configId): void;
}
