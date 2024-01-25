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
 * Object Storage keypair repository.
 */
interface ObjectStorageKeyRepositoryInterface extends RepositoryInterface
{
    /**
     * Provisions a new Object Storage Key on your account.
     *
     * @throws LinodeException
     */
    public function create(array $parameters): ObjectStorageKey;

    /**
     * Updates an Object Storage Key on your account.
     *
     * @throws LinodeException
     */
    public function update(int $id, array $parameters): ObjectStorageKey;

    /**
     * Revokes an Object Storage Key. This keypair will no longer be usable by third-party clients.
     *
     * @throws LinodeException
     */
    public function revoke(int $id): void;
}
