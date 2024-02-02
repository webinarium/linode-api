<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\NodeBalancers;

use Linode\Exception\LinodeException;
use Linode\Networking\Firewall;
use Linode\RepositoryInterface;

/**
 * NodeBalancer repository.
 *
 * @method NodeBalancer   find(int|string $id)
 * @method NodeBalancer[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method NodeBalancer[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method NodeBalancer   findOneBy(array $criteria)
 * @method NodeBalancer[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface NodeBalancerRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a NodeBalancer in the requested Region.
     *
     * NodeBalancers require a port Config with at least one backend Node to start
     * serving requests.
     *
     * When using the Linode CLI to create a NodeBalancer, first create a NodeBalancer
     * without any Configs. Then, create Configs and Nodes for that NodeBalancer with the
     * respective Config Create and Node Create commands.
     *
     * @param array $parameters Information about the NodeBalancer to create.
     *
     * @throws LinodeException
     */
    public function createNodeBalancer(array $parameters = []): NodeBalancer;

    /**
     * Updates information about a NodeBalancer you can access.
     *
     * @param int   $nodeBalancerId The ID of the NodeBalancer to access.
     * @param array $parameters     The information to update.
     *
     * @throws LinodeException
     */
    public function updateNodeBalancer(int $nodeBalancerId, array $parameters = []): NodeBalancer;

    /**
     * Deletes a NodeBalancer.
     *
     * **This is a destructive action and cannot be undone.**
     *
     * Deleting a NodeBalancer will also delete all associated Configs and Nodes,
     * although the backend servers represented by the Nodes will not be changed or
     * removed. Deleting a NodeBalancer will cause you to lose access to the IP Addresses
     * assigned to this NodeBalancer.
     *
     * @param int $nodeBalancerId The ID of the NodeBalancer to access.
     *
     * @throws LinodeException
     */
    public function deleteNodeBalancer(int $nodeBalancerId): void;

    /**
     * Returns detailed statistics about the requested NodeBalancer.
     *
     * @param int $nodeBalancerId The ID of the NodeBalancer to access.
     *
     * @throws LinodeException
     */
    public function getNodeBalancerStats(int $nodeBalancerId): NodeBalancerStats;

    /**
     * View information for Firewalls assigned to this NodeBalancer.
     *
     * @param int $nodeBalancerId The ID of the NodeBalancer to access.
     *
     * @return Firewall[] List of Firewalls assigned to this NodeBalancer.
     *
     * @throws LinodeException
     */
    public function getNodeBalancerFirewalls(int $nodeBalancerId): array;
}
