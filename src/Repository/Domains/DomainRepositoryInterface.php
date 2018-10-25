<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Repository\Domains;

use Linode\Entity\Domains\Domain;
use Linode\Repository\RepositoryInterface;

/**
 * Domain repository.
 */
interface DomainRepositoryInterface extends RepositoryInterface
{
    /**
     * Adds a new Domain to Linode's DNS Manager. Linode is not a registrar, and
     * you must own the domain before adding it here. Be sure to point your
     * registrar to Linode's nameservers so that the records hosted here are
     * used.
     *
     * @param array $parameters
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return Domain
     */
    public function create(array $parameters): Domain;

    /**
     * Update information about a Domain in Linode's DNS Manager.
     *
     * @param int   $id
     * @param array $parameters
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return Domain
     */
    public function update(int $id, array $parameters): Domain;

    /**
     * Deletes a Domain from Linode's DNS Manager. The Domain will be removed
     * from Linode's nameservers shortly after this operation completes. This
     * also deletes all associated Domain Records.
     *
     * @param int $id
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function delete(int $id): void;

    /**
     * Imports a domain zone from a remote nameserver.
     *
     * Your nameserver must allow zone transfers (AXFR) from the following IPs:
     *   - 96.126.114.97
     *   - 96.126.114.98
     *   - 2600:3c00::5e
     *   - 2600:3c00::5f
     *
     * @param string $domain
     * @param string $remote_nameserver
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return Domain
     */
    public function import(string $domain, string $remote_nameserver): Domain;
}
