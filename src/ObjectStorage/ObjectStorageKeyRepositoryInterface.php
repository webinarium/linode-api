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
 * ObjectStorageKey repository.
 *
 * @method ObjectStorageKey   find(int|string $id)
 * @method ObjectStorageKey[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method ObjectStorageKey[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method ObjectStorageKey   findOneBy(array $criteria)
 * @method ObjectStorageKey[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface ObjectStorageKeyRepositoryInterface extends RepositoryInterface
{
    /**
     * Provisions a new Object Storage Key on your account.
     *
     * * To create a Limited Access Key with specific permissions, send a `bucket_access`
     * array.
     *
     * * To create a Limited Access Key without access to any buckets, send an empty
     * `bucket_access` array.
     *
     * * To create an Access Key with unlimited access to all clusters and all buckets,
     * omit the `bucket_access` array.
     *
     * @param array $parameters The label of the key to create. This is used to identify the created key.
     *
     * @return ObjectStorageKey The new keypair. **This is the only time** the secret key is returned.
     *
     * @throws LinodeException
     */
    public function createObjectStorageKeys(array $parameters = []): ObjectStorageKey;

    /**
     * Updates an Object Storage Key on your account.
     *
     * @param int   $keyId      The key to look up.
     * @param array $parameters The fields to update.
     *
     * @throws LinodeException
     */
    public function updateObjectStorageKey(int $keyId, array $parameters = []): ObjectStorageKey;

    /**
     * Revokes an Object Storage Key. This keypair will no longer be usable by
     * third-party clients.
     *
     * @param int $keyId The key to look up.
     *
     * @throws LinodeException
     */
    public function deleteObjectStorageKey(int $keyId): void;
}
