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
     * **Beta**: This endpoint is in private beta. Please make sure to prepend all
     * requests with `/v4beta` instead of `/v4`, and be aware that this endpoint may
     * receive breaking updates in the future. This notice will be removed when this
     * endpoint is out of beta. Sign up for the beta here.
     *
     * @param array $parameters Configuration for the Node Pool
     *
     * @throws LinodeException
     */
    public function postLKEClusterPools(array $parameters = []): LKENodePool;

    /**
     * Updates a Node Pool. When a Node Pool's count are changed, the nodes in that pool
     * will be replaced in a rolling fashion.
     *
     * **Beta**: This endpoint is in private beta. Please make sure to prepend all
     * requests with `/v4beta` instead of `/v4`, and be aware that this endpoint may
     * receive breaking updates in the future. This notice will be removed when this
     * endpoint is out of beta. Sign up for the beta here.
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
     *
     * **Beta**: This endpoint is in private beta. Please make sure to prepend all
     * requests with
     * `/v4beta` instead of `/v4`, and be aware that this endpoint may receive breaking
     * updates in the future. This notice will be removed when this endpoint is out of
     * beta. Sign up for the beta here.
     *
     * @param int $poolId ID of the Pool to look up
     *
     * @throws LinodeException
     */
    public function deleteLKENodePool(int $poolId): void;

    /**
     * Get the Kubernetes API server endpoint for this cluster.
     *
     * **Beta**: This endpoint is in private beta. Please make sure to prepend all
     * requests with `/v4beta` instead of `/v4`, and be aware that this endpoint may
     * receive breaking updates in the future. This notice will be removed when this
     * endpoint is out of beta. Sign up for the beta here.
     *
     * @return string The Kubernetes API server endpoint for this cluster.
     *
     * @throws LinodeException
     */
    public function getLKEClusterAPIEndpoint(): string;

    /**
     * Get the Kubeconfig file for a Cluster.
     *
     * **Beta**: This endpoint is in private beta. Please make sure to prepend all
     * requests with `/v4beta` instead of `/v4`, and be aware that this endpoint may
     * receive breaking updates in the future. This notice will be removed when this
     * endpoint is out of beta. Sign up for the beta here.
     *
     * @return string The Base64-encoded Kubeconfig file for this Cluster.
     *
     * @throws LinodeException
     */
    public function getLKEClusterKubeconfig(): string;
}
