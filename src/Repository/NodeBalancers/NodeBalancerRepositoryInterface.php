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

use Linode\Entity\NodeBalancers\NodeBalancer;
use Linode\Entity\NodeBalancers\NodeBalancerStats;
use Linode\Repository\RepositoryInterface;

/**
 * NodeBalancer repository.
 */
interface NodeBalancerRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a NodeBalancer in the requested Region. This NodeBalancer
     * will not start serving requests until it is configured.
     *
     * @param array $parameters
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return NodeBalancer
     */
    public function create(array $parameters): NodeBalancer;

    /**
     * Updates information about a NodeBalancer you can access.
     *
     * @param int   $id
     * @param array $parameters
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return NodeBalancer
     */
    public function update(int $id, array $parameters): NodeBalancer;

    /**
     * Deletes a NodeBalancer.
     *
     * WARNING! This is a destructive action and cannot be undone.
     *
     * Deleting a NodeBalancer will also delete all associated Configs and Nodes,
     * although the backend servers represented by the Nodes will not be
     * changed or removed. Deleting a NodeBalancer will cause you to lose access
     * to the IP Addresses assigned to this NodeBalancer.
     *
     * @param int $id
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function delete(int $id): void;

    /**
     * Returns detailed statistics about the requested NodeBalancer.
     *
     * @param int $id
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return NodeBalancerStats
     */
    public function getStats(int $id): NodeBalancerStats;
}
