<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\LinodeInstances;

use Linode\Exception\LinodeException;
use Linode\RepositoryInterface;

/**
 * Configuration profile repository.
 */
interface ConfigurationProfileRepositoryInterface extends RepositoryInterface
{
    /**
     * Adds a new Configuration profile to a Linode.
     *
     * @throws LinodeException
     */
    public function create(array $parameters): ConfigurationProfile;

    /**
     * Updates a Configuration profile.
     *
     * @throws LinodeException
     */
    public function update(int $id, array $parameters): ConfigurationProfile;

    /**
     * Deletes the specified Configuration profile from the specified Linode.
     *
     * @throws LinodeException
     */
    public function delete(int $id): void;
}
