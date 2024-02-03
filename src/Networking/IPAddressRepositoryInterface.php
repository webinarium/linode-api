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
     * reset to the default _ip.linodeusercontent.com_ RDNS value.
     *
     * @param string $address    The address to operate on.
     * @param array  $parameters The information to update.
     *
     * @throws LinodeException
     */
    public function updateIP(string $address, array $parameters = []): IPAddress;

    /**
     * Assign multiple IPv4 addresses and/or IPv6 ranges to multiple Linodes in one
     * Region. This allows swapping, shuffling, or otherwise reorganizing IPs to your
     * Linodes.
     *
     * The following restrictions apply:
     * * All Linodes involved must have at least one public IPv4 address after
     * assignment.
     * * Linodes may have no more than one assigned private IPv4 address.
     * * Linodes may have no more than one assigned IPv6 range.
     * * Shared IP addresses cannot be swapped between Linodes.
     *
     * Open a Support Ticket to request additional IPv4 addresses or IPv6 ranges beyond
     * standard account limits.
     *
     * **Note**: Removing an IP address that has been set as a Managed Linode's `ssh.ip`
     * causes the Managed Linode's SSH access settings to reset to their default values.
     * To view and configure Managed Linode SSH settings, use the following commands:
     * * **Linode's Managed Settings View** (GET /managed/linode-settings/{linodeId})
     * * **Linode's Managed Settings Update** (PUT /managed/linode-settings/{linodeId})
     *
     * **Note:** Addresses with an active 1:1 NAT to a VPC Interface address cannot be
     * assigned to other Linodes.
     *
     * @param array $parameters Information about what IPv4 address or IPv6 range to assign, and to which Linode.
     *
     * @throws LinodeException
     */
    public function assignIPs(array $parameters = []): void;

    /**
     * Configure shared IPs.
     *
     * IP sharing allows IP address reassignment (also referred to as IP failover) from
     * one Linode to another if the primary Linode becomes unresponsive. This means that
     * requests to the primary Linode's IP address can be automatically rerouted to
     * secondary Linodes at the configured shared IP addresses.
     *
     * IP failover requires configuration of a failover service (such as Keepalived)
     * within the internal system of the primary Linode.
     *
     * **Note:** A public IPv4 address cannot be shared if it is configured for a 1:1 NAT
     * on a `vpc` purpose Configuration Profile Interface.
     *
     * @param array $parameters Information about what IPs to share with which Linode.
     *
     * @throws LinodeException
     */
    public function shareIPs(array $parameters = []): void;

    /**
     * This command is equivalent to **IP Addresses Assign** (POST
     * /networking/ips/assign).
     *
     * Assign multiple IPv4 addresses and/or IPv6 ranges to multiple Linodes in one
     * Region. This allows swapping, shuffling, or otherwise reorganizing IPs to your
     * Linodes.
     *
     * The following restrictions apply:
     * * All Linodes involved must have at least one public IPv4 address after
     * assignment.
     * * Linodes may have no more than one assigned private IPv4 address.
     * * Linodes may have no more than one assigned IPv6 range.
     *
     * Open a Support Ticket to request additional IPv4 addresses or IPv6 ranges beyond
     * standard account limits.
     *
     * **Note**: Removing an IP address that has been set as a Managed Linode's `ssh.ip`
     * causes the Managed Linode's SSH access settings to reset to their default values.
     * To view and configure Managed Linode SSH settings, use the following commands:
     * * **Linode's Managed Settings View** (GET /managed/linode-settings/{linodeId})
     * * **Linode's Managed Settings Update** (PUT /managed/linode-settings/{linodeId})
     *
     * @param array $parameters Information about what IPv4 address to assign, and to which Linode.
     *
     * @throws LinodeException
     */
    public function assignIPv4s(array $parameters = []): void;

    /**
     * This command is equivalent to **IP Addresses Share** (POST /networking/ips/share).
     *
     * Configure shared IPs.
     *
     * IP sharing allows IP address reassignment (also referred to as IP failover) from
     * one Linode to another if the primary Linode becomes unresponsive. This means that
     * requests to the primary Linode's IP address can be automatically rerouted to
     * secondary Linodes at the configured shared IP addresses.
     *
     * IP failover requires configuration of a failover service (such as Keepalived)
     * within the internal system of the primary Linode.
     *
     * @param array $parameters Information about what IPs to share with which Linode.
     *
     * @throws LinodeException
     */
    public function shareIPv4s(array $parameters = []): void;
}
