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
 * NodeBalancerNode repository.
 *
 * @method NodeBalancerNode   find(int|string $id)
 * @method NodeBalancerNode[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method NodeBalancerNode[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method NodeBalancerNode   findOneBy(array $criteria)
 * @method NodeBalancerNode[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface NodeBalancerNodeRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a NodeBalancer Node, a backend that can accept traffic for this
     * NodeBalancer Config. Nodes are routed requests on the configured port based on
     * their status.
     *
     * @param array $parameters Information about the Node to create.
     *
     * @throws LinodeException
     */
    public function createNodeBalancerNode(array $parameters = []): NodeBalancerNode;

    /**
     * Updates information about a Node, a backend for this NodeBalancer's configured
     * port.
     *
     * @param int   $nodeId     The ID of the Node to access
     * @param array $parameters The fields to update.
     *
     * @throws LinodeException
     */
    public function updateNodeBalancerNode(int $nodeId, array $parameters = []): NodeBalancerNode;

    /**
     * Deletes a Node from this Config. This backend will no longer receive traffic for
     * the configured port of this NodeBalancer.
     *
     * This does not change or remove the Linode whose address was used in the creation
     * of this Node.
     *
     * @param int $nodeId The ID of the Node to access
     *
     * @throws LinodeException
     */
    public function deleteNodeBalancerConfigNode(int $nodeId): void;
}
