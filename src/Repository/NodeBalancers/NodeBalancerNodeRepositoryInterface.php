<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Repository\NodeBalancers;

use Linode\Entity\NodeBalancers\NodeBalancerNode;
use Linode\Repository\RepositoryInterface;

/**
 * NodeBalancer node repository.
 */
interface NodeBalancerNodeRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a NodeBalancer Node, a backend that can accept
     * traffic for this NodeBalancer Config. Nodes are routed
     * requests on the configured port based on their status.
     *
     * @param array $parameters
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return NodeBalancerNode
     */
    public function create(array $parameters): NodeBalancerNode;

    /**
     * Updates information about a Node, a backend for this NodeBalancer's
     * configured port.
     *
     * @param int   $id
     * @param array $parameters
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return NodeBalancerNode
     */
    public function update(int $id, array $parameters): NodeBalancerNode;

    /**
     * Deletes a Node from this Config. This backend will no longer
     * receive traffic for the configured port of this NodeBalancer.
     *
     * This does not change or remove the Linode whose address was
     * used in the creation of this Node.
     *
     * @param int $id
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function delete(int $id): void;
}
