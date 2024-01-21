<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Repository\Networking;

use Linode\Entity\Networking\IPAddress;
use Linode\Exception\LinodeException;
use Linode\Repository\RepositoryInterface;

/**
 * IPAddress repository.
 */
interface IPAddressRepositoryInterface extends RepositoryInterface
{
    /**
     * Allocates a new IPv4 Address on your Account. The Linode must be
     * configured to support additional addresses - please open a support
     * ticket requesting additional addresses before attempting allocation.
     *
     * @param int    $linode_id the ID of a Linode you you have access to that this address
     *                          will be allocated to
     * @param bool   $public    whether to create a public or private IPv4 address
     * @param string $type      The type of address you are requesting. Only IPv4 addresses
     *                          may be allocated through this endpoint.
     *
     * @throws LinodeException
     */
    public function allocate(int $linode_id, bool $public, string $type = IPAddress::TYPE_IP4): IPAddress;

    /**
     * Updates an IP Address. Only allows setting/resetting reverse DNS.
     *
     * Forward DNS must already be set up for reverse DNS to be applied.
     * If you set the RDNS to `null` for public IPv4 addresses, it will
     * be reset to the default _members.linode.com_  RDNS value.
     *
     * @throws LinodeException
     */
    public function update(string $id, array $parameters): IPAddress;

    /**
     * Assign multiple IPs to multiple Linodes in one Region. This allows
     * swapping, shuffling, or otherwise reorganizing IPv4 Addresses to your
     * Linodes. When the assignment is finished, all Linodes must end up with
     * at least one public IPv4 and no more than one private IPv4.
     *
     * @param string $region      The ID of the Region in which these assignments are to take
     *                            place. All IPs and Linodes must exist in this Region.
     * @param array  $assignments The list of assignments to make. You must have read_write
     *                            access to all IPs being assigned and all Linodes being
     *                            assigned to in order for the assignments to succeed.
     *
     * @throws LinodeException
     */
    public function assign(string $region, array $assignments): void;

    /**
     * Configure shared IPs. A shared IP may be brought up on a Linode other
     * than the one it lists in its response. This can be used to allow one
     * Linode to begin serving requests should another become unresponsive.
     *
     * @param int      $linode_id the ID of the Linode that the addresses will be shared with
     * @param string[] $ips       A list of IPs that will be shared with this Linode. When
     *                            this is finished, the given Linode will be able to bring up
     *                            these addresses in addition to the Linodes that these
     *                            addresses belong to. You must have access to all of these
     *                            addresses and they must be in the same Region as the Linode.
     *
     * @throws LinodeException
     */
    public function share(int $linode_id, array $ips): void;
}
