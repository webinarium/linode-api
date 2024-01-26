<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Networking;

use Linode\Exception\LinodeException;
use Linode\RepositoryInterface;

/**
 * IPAddress repository.
 *
 * @method IPAddress   find(int|string $id)
 * @method IPAddress[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method IPAddress[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method IPAddress   findOneBy(array $criteria)
 * @method IPAddress[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface IPAddressRepositoryInterface extends RepositoryInterface
{
    /**
     * Allocates a new IPv4 Address on your Account. The Linode must be configured to
     * support additional addresses - please open a support ticket requesting additional
     * addresses before attempting allocation.
     *
     * @param array $parameters Information about the address you are creating.
     *
     * @throws LinodeException
     */
    public function allocateIP(array $parameters = []): IPAddress;

    /**
     * Sets RDNS on an IP Address. Forward DNS must already be set up for reverse DNS to
     * be applied. If you set the RDNS to `null` for public IPv4 addresses, it will be
     * reset to the default _members.linode.com_ RDNS value.
     *
     * @param string $address    The address to operate on.
     * @param array  $parameters The information to update.
     *
     * @throws LinodeException
     */
    public function updateIP(string $address, array $parameters = []): IPAddress;

    /**
     * Assign multiple IPs to multiple Linodes in one Region. This allows swapping,
     * shuffling, or otherwise reorganizing IPv4 Addresses to your Linodes. When the
     * assignment is finished, all Linodes must end up with at least one public IPv4 and
     * no more than one private IPv4.
     *
     * @param array $parameters Information about what IPv4 address to assign, and to which Linode.
     *
     * @throws LinodeException
     */
    public function assignIPs(array $parameters = []): void;

    /**
     * Configure shared IPs. A shared IP may be brought up on a Linode other than the one
     * it lists in its response. This can be used to allow one Linode to begin serving
     * requests should another become unresponsive.
     *
     * @param array $parameters Information about what IPs to share with which Linode.
     *
     * @throws LinodeException
     */
    public function shareIPs(array $parameters = []): void;
}
