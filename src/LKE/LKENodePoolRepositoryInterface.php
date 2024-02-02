<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\LKE;

use Linode\Exception\LinodeException;
use Linode\RepositoryInterface;

/**
 * LKENodePool repository.
 *
 * @method LKENodePool   find(int|string $id)
 * @method LKENodePool[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method LKENodePool[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method LKENodePool   findOneBy(array $criteria)
 * @method LKENodePool[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface LKENodePoolRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a new Node Pool for the designated Kubernetes cluster.
     *
     * @param array $parameters Configuration for the Node Pool
     *
     * @throws LinodeException
     */
    public function postLKEClusterPools(array $parameters = []): LKENodePool;

    /**
     * Updates a Node Pool's count and autoscaler configuration.
     *
     * Linodes will be created or deleted to match changes to the Node Pool's count.
     *
     * **Any local storage on deleted Linodes (such as "hostPath" and "emptyDir" volumes,
     * or "local" PersistentVolumes) will be erased.**
     *
     * @param int   $poolId     ID of the Pool to look up
     * @param array $parameters The fields to update
     *
     * @throws LinodeException
     */
    public function putLKENodePool(int $poolId, array $parameters = []): LKENodePool;

    /**
     * Delete a specific Node Pool from a Kubernetes cluster.
     *
     * **Deleting a Node Pool is a destructive action and cannot be undone.**
     *
     * Deleting a Node Pool will delete all Linodes within that Pool.
     *
     * @param int $poolId ID of the Pool to look up
     *
     * @throws LinodeException
     */
    public function deleteLKENodePool(int $poolId): void;

    /**
     * Recycles a Node Pool for the designated Kubernetes Cluster. All Linodes within the
     * Node Pool will be deleted
     * and replaced with new Linodes on a rolling basis, which may take several minutes.
     * Replacement Nodes are
     * installed with the latest available patch for the Cluster's Kubernetes Version.
     *
     * **Any local storage on deleted Linodes (such as "hostPath" and "emptyDir" volumes,
     * or "local" PersistentVolumes) will be erased.**
     *
     * @param int $poolId ID of the Node Pool to be recycled.
     *
     * @throws LinodeException
     */
    public function postLKEClusterPoolRecycle(int $poolId): void;

    /**
     * List the Kubernetes API server endpoints for this cluster. Please note that it
     * often takes 2-5 minutes before the endpoint is ready after first creating a new
     * cluster.
     *
     * @return string[] The Kubernetes API server endpoints for this cluster.
     *
     * @throws LinodeException
     */
    public function getLKEClusterAPIEndpoints(): array;
}
