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
     * **Beta**: This endpoint is in beta. Please make sure to prepend all requests with
     * `/v4beta` instead of `/v4`, and be aware that this endpoint may receiving breaking
     * updates in the future. This notice will be removed when this endpoint is out of
     * beta.
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
     * **Beta**: This endpoint is in beta. Please make sure to prepend all requests with
     * `/v4beta` instead of `/v4`, and be aware that this endpoint may receiving breaking
     * updates in the future. This notice will be removed when this endpoint is out of
     * beta.
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
     * **Beta**: This endpoint is in beta. Please make sure to prepend all requests with
     * `/v4beta` instead of `/v4`, and be aware that this endpoint may receiving breaking
     * updates in the future. This notice will be removed when this endpoint is out of
     * beta.
     *
     * @param int $keyId The key to look up.
     *
     * @throws LinodeException
     */
    public function deleteObjectStorageKey(int $keyId): void;
}
