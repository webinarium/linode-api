<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Domains;

use Linode\Exception\LinodeException;
use Linode\RepositoryInterface;

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
     * @throws LinodeException
     */
    public function create(array $parameters): Domain;

    /**
     * Update information about a Domain in Linode's DNS Manager.
     *
     * @throws LinodeException
     */
    public function update(int $id, array $parameters): Domain;

    /**
     * Deletes a Domain from Linode's DNS Manager. The Domain will be removed
     * from Linode's nameservers shortly after this operation completes. This
     * also deletes all associated Domain Records.
     *
     * @throws LinodeException
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
     * @param string $domain            the domain to import
     * @param string $remote_nameserver the remote nameserver that allows zone transfers (AXFR)
     *
     * @throws LinodeException
     */
    public function import(string $domain, string $remote_nameserver): Domain;

    /**
     * Clones a Domain and all associated DNS records from a Domain that is
     * registered in Linode's DNS manager.
     *
     * @param string $domain the new domain being created
     *
     * @throws LinodeException
     */
    public function clone(int $id, string $domain): Domain;
}
