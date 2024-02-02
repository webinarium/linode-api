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
 * LKECluster repository.
 *
 * @method LKECluster   find(int|string $id)
 * @method LKECluster[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method LKECluster[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method LKECluster   findOneBy(array $criteria)
 * @method LKECluster[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface LKEClusterRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a Kubernetes cluster. The Kubernetes cluster will be created
     * asynchronously. You can use the events system to determine when the
     * Kubernetes cluster is ready to use. Please note that it often takes 2-5 minutes
     * before the
     * Kubernetes API server endpoint and
     * the Kubeconfig file for the new cluster
     * are ready.
     *
     * @param array $parameters Configuration for the Kubernetes cluster
     *
     * @throws LinodeException
     */
    public function createLKECluster(array $parameters = []): LKECluster;

    /**
     * Updates a Kubernetes cluster.
     *
     * @param int   $clusterId  ID of the Kubernetes cluster to look up.
     * @param array $parameters The fields to update the Kubernetes cluster.
     *
     * @throws LinodeException
     */
    public function putLKECluster(int $clusterId, array $parameters = []): LKECluster;

    /**
     * Deletes a Cluster you have permission to `read_write`.
     *
     * **Deleting a Cluster is a destructive action and cannot be undone.**
     *
     * Deleting a Cluster:
     *   - Deletes all Linodes in all pools within this Kubernetes cluster
     *   - Deletes all supporting Kubernetes services for this Kubernetes
     *     cluster (API server, etcd, etc)
     *   - Deletes all NodeBalancers created by this Kubernetes cluster
     *   - Does not delete any of the volumes created by this Kubernetes
     *     cluster
     *
     * @param int $clusterId ID of the Kubernetes cluster to look up.
     *
     * @throws LinodeException
     */
    public function deleteLKECluster(int $clusterId): void;

    /**
     * Get a Kubernetes Dashboard access URL for this Cluster, which enables performance
     * of administrative tasks through a web interface.
     *
     * Dashboards are installed for Clusters by default.
     *
     * To access the Cluster Dashboard login prompt, enter the URL in a web browser.
     * Select either **Token** or **Kubeconfig** authentication, then select **Sign in**.
     *
     * For additional guidance on using the Cluster Dashboard, see the Navigating the
     * Cluster Dashboard section of our guide on Using the Kubernetes Dashboard on LKE.
     *
     * @param int $clusterId ID of the Kubernetes cluster to look up.
     *
     * @return string The Cluster Dashboard access URL.
     *
     * @throws LinodeException
     */
    public function getLKEClusterDashboard(int $clusterId): string;

    /**
     * Recycles all nodes in all pools of a designated Kubernetes Cluster. All Linodes
     * within the Cluster will be deleted
     * and replaced with new Linodes on a rolling basis, which may take several minutes.
     * Replacement Nodes are
     * installed with the latest available patch version for the Cluster's current
     * Kubernetes minor release.
     *
     * **Any local storage on deleted Linodes (such as "hostPath" and "emptyDir" volumes,
     * or "local" PersistentVolumes) will be erased.**
     *
     * @param int $clusterId ID of the Kubernetes cluster which contains nodes to be recycled.
     *
     * @throws LinodeException
     */
    public function postLKEClusterRecycle(int $clusterId): void;

    /**
     * Returns the values for a specified node object.
     *
     * @param int    $clusterId ID of the Kubernetes cluster containing the Node.
     * @param string $nodeId    ID of the Node to look up.
     *
     * @return LKENodeStatus The selected node in the cluster.
     *
     * @throws LinodeException
     */
    public function getLKEClusterNode(int $clusterId, string $nodeId): LKENodeStatus;

    /**
     * Deletes a specific Node from a Node Pool.
     *
     * **Deleting a Node is a destructive action and cannot be undone.**
     *
     * Deleting a Node will reduce the size of the Node Pool it belongs to.
     *
     * @param int    $clusterId ID of the Kubernetes cluster containing the Node.
     * @param string $nodeId    ID of the Node to look up.
     *
     * @throws LinodeException
     */
    public function deleteLKEClusterNode(int $clusterId, string $nodeId): void;

    /**
     * Recycles an individual Node in the designated Kubernetes Cluster. The Node will be
     * deleted
     * and replaced with a new Linode, which may take a few minutes. Replacement Nodes
     * are
     * installed with the latest available patch for the Cluster's Kubernetes Version.
     *
     * **Any local storage on deleted Linodes (such as "hostPath" and "emptyDir" volumes,
     * or "local" PersistentVolumes) will be erased.**
     *
     * @param int    $clusterId ID of the Kubernetes cluster containing the Node.
     * @param string $nodeId    ID of the Node to be recycled.
     *
     * @throws LinodeException
     */
    public function postLKEClusterNodeRecycle(int $clusterId, string $nodeId): void;

    /**
     * Get the Kubeconfig file for a Cluster. Please note that it often takes 2-5 minutes
     * before
     * the Kubeconfig file is ready after first creating a new cluster.
     *
     * @param int $clusterId ID of the Kubernetes cluster to look up.
     *
     * @return string The Base64-encoded Kubeconfig file for this Cluster.
     *
     * @throws LinodeException
     */
    public function getLKEClusterKubeconfig(int $clusterId): string;

    /**
     * Delete and regenerate the Kubeconfig file for a Cluster.
     *
     * @param int $clusterId ID of the Kubernetes cluster to look up.
     *
     * @throws LinodeException
     */
    public function deleteLKEClusterKubeconfig(int $clusterId): void;
}
