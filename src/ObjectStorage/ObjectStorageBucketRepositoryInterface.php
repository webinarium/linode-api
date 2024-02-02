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
     * Removes a single bucket.
     *
     * Bucket objects must be removed prior to removing the bucket. While buckets
     * containing objects _may_ be
     * deleted using the s3cmd command-line tool, such operations
     * can fail if the bucket contains too many objects. The recommended
     * way to empty large buckets is to use the S3 API to configure lifecycle policies
     * that
     * remove all objects, then delete the bucket.
     *
     * This endpoint is available for convenience. It is recommended that instead you
     * use the more fully-featured S3 API directly.
     *
     * @param string $bucket The bucket name.
     *
     * @throws LinodeException
     */
    public function deleteObjectStorageBucket(string $bucket): void;

    /**
     * Allows changing basic Cross-origin Resource Sharing (CORS) and Access Control
     * Level (ACL) settings.
     * Only allows enabling/disabling CORS for all origins, and/or setting canned ACLs.
     *
     * For more fine-grained control of both systems, please use the more fully-featured
     * S3 API directly.
     *
     * @param string $bucket     The bucket name.
     * @param array  $parameters The changes to make to the bucket's access controls.
     *
     * @throws LinodeException
     */
    public function modifyObjectStorageBucketAccess(string $bucket, array $parameters = []): void;

    /**
     * Allows changing basic Cross-origin Resource Sharing (CORS) and Access Control
     * Level (ACL) settings.
     * Only allows enabling/disabling CORS for all origins, and/or setting canned ACLs.
     *
     * For more fine-grained control of both systems, please use the more fully-featured
     * S3 API directly.
     *
     * @param string $bucket     The bucket name.
     * @param array  $parameters The changes to make to the bucket's access controls.
     *
     * @throws LinodeException
     */
    public function updateObjectStorageBucketAccess(string $bucket, array $parameters = []): void;

    /**
     * View an Object’s configured Access Control List (ACL) in this Object Storage
     * bucket.
     * ACLs define who can access your buckets and objects and specify the level of
     * access
     * granted to those users.
     *
     * This endpoint is available for convenience. It is recommended that instead you
     * use the more fully-featured S3 API directly.
     *
     * @param string $bucket The bucket name.
     *
     * @return ObjectACL The Object's canned ACL and policy.
     *
     * @throws LinodeException
     */
    public function viewObjectStorageBucketACL(string $bucket): ObjectACL;

    /**
     * Update an Object's configured Access Control List (ACL) in this Object Storage
     * bucket.
     * ACLs define who can access your buckets and objects and specify the level of
     * access
     * granted to those users.
     *
     * This endpoint is available for convenience. It is recommended that instead you
     * use the more fully-featured S3 API directly.
     *
     * @param string $bucket     The bucket name.
     * @param array  $parameters The changes to make to this Object's access controls.
     *
     * @return ObjectACL The Object's canned ACL and policy.
     *
     * @throws LinodeException
     */
    public function updateObjectStorageBucketACL(string $bucket, array $parameters = []): ObjectACL;

    /**
     * Returns the contents of a bucket. The contents are paginated using a `marker`,
     * which is the name of the last object on the previous page. Objects may
     * be filtered by `prefix` and `delimiter` as well; see Query Parameters for more
     * information.
     *
     * This endpoint is available for convenience. It is recommended that instead you
     * use the more fully-featured S3 API directly.
     *
     * @param string $bucket The bucket name.
     *
     * @return ObjectStorageObject[] One page of the requested bucket's contents.
     *
     * @throws LinodeException
     */
    public function getObjectStorageBucketContent(string $bucket): array;

    /**
     * Creates a pre-signed URL to access a single Object in a bucket. This
     * can be used to share objects, and also to create/delete objects by using
     * the appropriate HTTP method in your request body's `method` parameter.
     *
     * This endpoint is available for convenience. It is recommended that instead you
     * use the more fully-featured S3 API
     * directly.
     *
     * @param string $bucket     The bucket name.
     * @param array  $parameters Information about the request to sign.
     *
     * @return string The signed URL to perform the request at.
     *
     * @throws LinodeException
     */
    public function createObjectStorageObjectURL(string $bucket, array $parameters = []): string;

    /**
     * Returns a boolean value indicating if this bucket has a corresponding TLS/SSL
     * certificate that was
     * uploaded by an Account user.
     *
     * @param string $bucket The bucket name.
     *
     * @return bool A boolean indicating if this Bucket has a corresponding TLS/SSL certificate that
     *              was uploaded by an Account user.
     *
     * @throws LinodeException
     */
    public function getObjectStorageSSL(string $bucket): bool;

    /**
     * Upload a TLS/SSL certificate and private key to be served when you visit your
     * Object Storage bucket via HTTPS.
     * Your TLS/SSL certificate and private key are stored encrypted at rest.
     *
     * To replace an expired certificate, delete your current certificate
     * and upload a new one.
     *
     * @param string $bucket     The bucket name.
     * @param array  $parameters Upload this TLS/SSL certificate with its corresponding secret key.
     *
     * @return bool A boolean indicating if this Bucket has a corresponding TLS/SSL certificate that
     *              was uploaded by an Account user.
     *
     * @throws LinodeException
     */
    public function createObjectStorageSSL(string $bucket, array $parameters = []): bool;

    /**
     * Deletes this Object Storage bucket's user uploaded TLS/SSL certificate and private
     * key.
     *
     * @param string $bucket The bucket name.
     *
     * @throws LinodeException
     */
    public function deleteObjectStorageSSL(string $bucket): void;

    /**
     * The amount of outbound data transfer used by your account's Object Storage
     * buckets.
     * Object Storage adds 1 terabyte of outbound data transfer to your data transfer
     * pool.
     * See the Object Storage Pricing and Limitations
     * guide for details on Object Storage transfer quotas.
     *
     * @return int The amount of outbound data transfer used by your account's Object Storage
     *             buckets, in GB, for the current month’s billing cycle.
     *
     * @throws LinodeException
     */
    public function getObjectStorageTransfer(): int;

    /**
     * Cancel Object Storage on an Account.
     *
     * **Warning**: Removes all buckets and their contents from your Account. This data
     * is irretrievable once removed.
     *
     * @throws LinodeException
     */
    public function cancelObjectStorage(): void;
}
