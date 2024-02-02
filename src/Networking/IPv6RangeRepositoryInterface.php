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
 * IPv6Range repository.
 *
 * @method IPv6Range   find(int|string $id)
 * @method IPv6Range[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method IPv6Range[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method IPv6Range   findOneBy(array $criteria)
 * @method IPv6Range[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface IPv6RangeRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates an IPv6 Range and assigns it based on the provided Linode or route target
     * IPv6 SLAAC address. See the `ipv6` property when accessing the Linode View (GET
     * /linode/instances/{linodeId}) endpoint to view a Linode's IPv6 SLAAC address.
     *   * Either `linode_id` or `route_target` is required in a request.
     *   * `linode_id` and `route_target` are mutually exclusive. Submitting values for
     * both properties in a request results in an error.
     *   * Upon a successful request, an IPv6 range is created in the Region that
     * corresponds to the provided `linode_id` or `route_target`.
     *   * Your Linode is responsible for routing individual addresses in the range, or
     * handling traffic for all the addresses in the range.
     *   * Access the IP Addresses Assign (POST /networking/ips/assign) endpoint to
     * re-assign IPv6 Ranges to your Linodes.
     *
     * **Note**: The following restrictions apply:
     *   * A Linode can only have one IPv6 range targeting its SLAAC address.
     *   * An account can only have one IPv6 range in each Region.
     *   * Open a Support Ticket to request expansion of these restrictions.
     *
     * @param array $parameters Information about the IPv6 range to create.
     *
     * @return IPv6Range IPv6 range created successfully.
     *
     * @throws LinodeException
     */
    public function postIPv6Range(array $parameters = []): IPv6Range;

    /**
     * Removes this IPv6 range from your account and disconnects the range from any
     * assigned Linodes.
     *
     * **Note:** Shared IPv6 ranges cannot be deleted at this time. Please contact
     * Customer Support for assistance.
     *
     * @param string $range The IPv6 range to access. Corresponds to the `range` property of objects returned
     *                      from the IPv6 Ranges List (GET /networking/ipv6/ranges) command.
     *
     **Note**: Omit the prefix length of the IPv6 range.
     *
     * @throws LinodeException
     */
    public function deleteIPv6Range(string $range): void;
}
