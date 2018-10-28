<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Repository\Linode;

use Linode\Entity\Linode\ConfigurationProfile;
use Linode\Repository\RepositoryInterface;

/**
 * Configuration profile repository.
 */
interface ConfigurationProfileRepositoryInterface extends RepositoryInterface
{
    /**
     * Adds a new Configuration profile to a Linode.
     *
     * @param array $parameters
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return ConfigurationProfile
     */
    public function create(array $parameters): ConfigurationProfile;

    /**
     * Updates a Configuration profile.
     *
     * @param int   $id
     * @param array $parameters
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return ConfigurationProfile
     */
    public function update(int $id, array $parameters): ConfigurationProfile;

    /**
     * Deletes the specified Configuration profile from the specified Linode.
     *
     * @param int $id
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function delete(int $id): void;
}
