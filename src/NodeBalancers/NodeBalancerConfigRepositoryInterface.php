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
use Linode\RepositoryInterface;

/**
 * NodeBalancerConfig repository.
 *
 * @method NodeBalancerConfig   find(int|string $id)
 * @method NodeBalancerConfig[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method NodeBalancerConfig[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method NodeBalancerConfig   findOneBy(array $criteria)
 * @method NodeBalancerConfig[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface NodeBalancerConfigRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a NodeBalancer Config, which allows the NodeBalancer to accept traffic on
     * a new port. You will need to add NodeBalancer Nodes to the new Config before it
     * can actually serve requests.
     *
     * @param array $parameters Information about the port to configure.
     *
     * @throws LinodeException
     */
    public function createNodeBalancerConfig(array $parameters = []): NodeBalancerConfig;

    /**
     * Updates the configuration for a single port on a NodeBalancer.
     *
     * @param int   $configId   The ID of the config to access.
     * @param array $parameters The fields to update.
     *
     * @throws LinodeException
     */
    public function updateNodeBalancerConfig(int $configId, array $parameters = []): NodeBalancerConfig;

    /**
     * Deletes the Config for a port of this NodeBalancer.
     *
     * **This cannot be undone.**
     *
     * Once completed, this NodeBalancer will no longer respond to requests on the given
     * port. This also deletes all associated NodeBalancerNodes, but the Linodes they
     * were routing traffic to will be unchanged and will not be removed.
     *
     * @param int $configId The ID of the config to access.
     *
     * @throws LinodeException
     */
    public function deleteNodeBalancerConfig(int $configId): void;

    /**
     * Rebuilds a NodeBalancer Config and its Nodes that you have permission to modify.
     *
     * @param int   $configId   The ID of the Config to access.
     * @param array $parameters Information about the NodeBalancer Config to rebuild.
     *
     * @throws LinodeException
     */
    public function rebuildNodeBalancerConfig(int $configId, array $parameters = []): NodeBalancer;
}
