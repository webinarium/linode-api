<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Regions;

use Linode\Exception\LinodeException;
use Linode\RepositoryInterface;

/**
 * Region repository.
 *
 * @method Region   find(int|string $id)
 * @method Region[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Region[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Region   findOneBy(array $criteria)
 * @method Region[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface RegionRepositoryInterface extends RepositoryInterface
{
    /**
     * Returns availability data for all Regions.
     *
     * Currently, this command returns availability of select premium and GPU plans for
     * select regions.
     *
     * @return RegionAvailability[] Region Availability objects.
     *
     * @throws LinodeException
     */
    public function getRegionsAvailability(): array;

    /**
     * Returns availability data for a single Region.
     *
     * @param string $regionId ID of the Region to look up.
     *
     * @throws LinodeException
     */
    public function getRegionAvailability(string $regionId): RegionAvailability;
}
