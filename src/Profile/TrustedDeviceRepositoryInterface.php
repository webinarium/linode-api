<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Profile;

use Linode\Exception\LinodeException;
use Linode\RepositoryInterface;

/**
 * TrustedDevice repository.
 *
 * @method TrustedDevice   find(int|string $id)
 * @method TrustedDevice[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method TrustedDevice[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method TrustedDevice   findOneBy(array $criteria)
 * @method TrustedDevice[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface TrustedDeviceRepositoryInterface extends RepositoryInterface
{
    /**
     * Revoke an active TrustedDevice for your User. Once a TrustedDevice is revoked,
     * this device will have to log in again before accessing your Linode account.
     *
     * @param int $deviceId The ID of the TrustedDevice
     *
     * @throws LinodeException
     */
    public function revokeTrustedDevice(int $deviceId): void;
}
