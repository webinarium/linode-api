<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Repository\Managed;

use Linode\Entity\Managed\ManagedCredential;
use Linode\Repository\RepositoryInterface;

/**
 * Managed credential repository.
 */
interface ManagedCredentialRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a Managed Credential. A Managed Credential is stored securely
     * to allow Linode special forces to access your Managed Services and resolve
     * issues.
     *
     * @param array $parameters
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return ManagedCredential
     */
    public function create(array $parameters): ManagedCredential;

    /**
     * Updates information about a Managed Credential.
     *
     * @param int   $id
     * @param array $parameters
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return ManagedCredential
     */
    public function update(int $id, array $parameters): ManagedCredential;

    /**
     * Deletes a Managed Credential. Linode special forces will no longer
     * have access to this Credential when attempting to resolve issues.
     *
     * @param int $id
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function delete(int $id): void;
}
