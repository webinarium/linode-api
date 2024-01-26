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
 * ManagedLinodeSettings repository.
 *
 * @method ManagedLinodeSettings   find(int|string $id)
 * @method ManagedLinodeSettings[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method ManagedLinodeSettings[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method ManagedLinodeSettings   findOneBy(array $criteria)
 * @method ManagedLinodeSettings[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface ManagedLinodeSettingsRepositoryInterface extends RepositoryInterface
{
    /**
     * Updates a single Linode's Managed settings.
     *
     * @param int   $linodeId   The Linode ID whose settings we are accessing.
     * @param array $parameters The settings to update.
     *
     * @throws LinodeException
     */
    public function updateManagedLinodeSetting(int $linodeId, array $parameters = []): ManagedLinodeSettings;
}
