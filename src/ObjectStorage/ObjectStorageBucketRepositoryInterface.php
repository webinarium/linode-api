<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\ObjectStorage;

use Linode\Exception\LinodeException;
use Linode\RepositoryInterface;

/**
 * ObjectStorageBucket repository.
 *
 * @method ObjectStorageBucket   find(int|string $id)
 * @method ObjectStorageBucket[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method ObjectStorageBucket[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method ObjectStorageBucket   findOneBy(array $criteria)
 * @method ObjectStorageBucket[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface ObjectStorageBucketRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates an Object Storage Bucket in the cluster specified. If the
     * bucket already exists and is owned by you, this endpoint will return a
     * `200` response with that bucket as if it had just been created.
     *
     * This endpoint is available for convenience. It is recommended that instead you
     * use the more fully-featured S3 API directly.
     *
     * @param array $parameters Information about the bucket you want to create.
     *
     * @throws LinodeException
     */
    public function createObjectStorageBucket(array $parameters = []): ObjectStorageBucket;

    /**
     * Returns a single Object Storage Bucket.
     *
     * This endpoint is available for convenience. It is recommended that instead you
     * use the more fully-featured S3 API directly.
     *
     * @param string $clusterId The ID of the cluster this bucket exists in.
     * @param string $bucket    The bucket name.
     *
     * @throws LinodeException
     */
    public function getObjectStorageBucket(string $clusterId, string $bucket): ObjectStorageBucket;

    /**
     * Removes a single bucket. While buckets containing objects _may_ be deleted by
     * including the `force` option in the request, such operations will fail if the
     * bucket contains too many objects. The recommended way to empty large buckets is to
     * use the S3 API to configure lifecycle policies that remove all objects, then
     * delete the bucket.
     *
     * This endpoint is available for convenience. It is recommended that instead you use
     * the more fully- featured S3 API directly.
     *
     * @param string $clusterId The ID of the cluster this bucket exists in.
     * @param string $bucket    The bucket name.
     *
     * @throws LinodeException
     */
    public function deleteObjectStorageBucket(string $clusterId, string $bucket): void;

    /**
     * Allows changing basic Cross-origin Resource Sharing (CORS) and Access Control
     * Level (ACL) settings.
     * Only allows enabling/disabling CORS for all origins, and/or setting canned ACLs.
     * For more fine-grained control of both systems, please use the S3 API directly.
     *
     * This endpoint is available for convenience. It is recommended that instead you
     * use the more more fully-featured S3 API directly.
     *
     * @param string $clusterId  The ID of the cluster this bucket exists in.
     * @param string $bucket     The bucket name.
     * @param array  $parameters The changes to make to the bucket's access controls.
     *
     * @throws LinodeException
     */
    public function modifyObjectStorageBucketAccess(string $clusterId, string $bucket, array $parameters = []): void;

    /**
     * Returns the contents of a bucket. The contents are paginated using a `marker`,
     * which is the name of the last object on the previous page. Objects may
     * be filtered by `prefix` and `delimiter` as well; see Query Parameters for more
     * information.
     *
     * This endpoint is available for convenience. It is recommended that instead you
     * use the more fully-featured S3 API directly.
     *
     * @param string $clusterId The ID of the cluster this bucket exists in.
     * @param string $bucket    The bucket name.
     *
     * @return ObjectStorageObject[] One page of the requested bucket's contents.
     *
     * @throws LinodeException
     */
    public function getObjectStorageBucketContent(string $clusterId, string $bucket): array;

    /**
     * Creates a pre-signed URL to access a single Object in a bucket. This
     * can be used to share objects, and also to create/delete objects by using
     * the appropriate HTTP method in your request body's `method` parameter.
     *
     * This endpoint is available for convenience. It is recommended that instead you
     * use the more fully-featured S3 API
     * directly.
     *
     * @param string $clusterId  The ID of the cluster this bucket exists in.
     * @param string $bucket     The bucket name.
     * @param array  $parameters Information about the request to sign.
     *
     * @return string The signed URL to perform the request at.
     *
     * @throws LinodeException
     */
    public function createObjectStorageObjectURL(string $clusterId, string $bucket, array $parameters = []): string;

    /**
     * Cancel Object Storage on an Account. All buckets on the Account must be empty
     * before Object Storage can be cancelled:
     *
     * - To delete a smaller number of objects, review the instructions in our
     * How to Use Object Storage
     * guide.
     * - To delete large amounts of objects, consult our guide on
     * Lifecycle Policies.
     *
     * @throws LinodeException
     */
    public function cancelObjectStorage(): void;
}
