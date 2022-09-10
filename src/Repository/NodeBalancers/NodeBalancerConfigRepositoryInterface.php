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
use Linode\Entity\NodeBalancers\NodeBalancerConfig;
use Linode\Repository\RepositoryInterface;

/**
 * NodeBalancer config repository.
 */
interface NodeBalancerConfigRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a NodeBalancer Config, which allows the NodeBalancer to
     * accept traffic on a new port. You will need to add NodeBalancer Nodes
     * to the new Config before it can actually serve requests.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function create(array $parameters): NodeBalancerConfig;

    /**
     * Updates the configuration for a single port on a NodeBalancer.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function update(int $id, array $parameters): NodeBalancerConfig;

    /**
     * Deletes the Config for a port of this NodeBalancer.
     *
     * WARNING! This cannot be undone.
     *
     * Once completed, this NodeBalancer will no longer
     * respond to requests on the given port. This also deletes all
     * associated NodeBalancerNodes, but the Linodes they were routing
     * traffic to will be unchanged and will not be removed.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function delete(int $id): void;

    /**
     * Rebuilds a NodeBalancer Config and its Nodes that you have
     * permission to modify.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function rebuild(int $id, array $parameters): NodeBalancer;
}
