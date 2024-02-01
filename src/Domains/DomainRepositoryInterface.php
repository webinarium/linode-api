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
 *
 * @method Domain   find(int|string $id)
 * @method Domain[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Domain[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Domain   findOneBy(array $criteria)
 * @method Domain[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface DomainRepositoryInterface extends RepositoryInterface
{
    /**
     * Adds a new Domain to Linode's DNS Manager. Linode is not a registrar, and you must
     * own the domain before adding it here. Be sure to point your registrar to Linode's
     * nameservers so that the records hosted here are used.
     *
     * @param array $parameters Information about the domain you are registering.
     *
     * @throws LinodeException
     */
    public function createDomain(array $parameters = []): Domain;

    /**
     * Update information about a Domain in Linode's DNS Manager.
     *
     * @param int   $domainId   The ID of the Domain to access.
     * @param array $parameters The Domain information to update.
     *
     * @throws LinodeException
     */
    public function updateDomain(int $domainId, array $parameters = []): Domain;

    /**
     * Deletes a Domain from Linode's DNS Manager. The Domain will be removed from
     * Linode's nameservers shortly after this operation completes. This also deletes all
     * associated Domain Records.
     *
     * @param int $domainId The ID of the Domain to access.
     *
     * @throws LinodeException
     */
    public function deleteDomain(int $domainId): void;

    /**
     * Returns the zone file for the last rendered zone for the specified domain.
     *
     * @param string $domainId ID of the Domain.
     *
     * @return string[] An array containing the lines of the domain zone file.
     *
     * @throws LinodeException
     */
    public function getDomainZone(string $domainId): array;

    /**
     * Imports a domain zone from a remote nameserver.
     * Your nameserver must allow zone transfers (AXFR) from the following IPs:
     *
     *   - 96.126.114.97
     *   - 96.126.114.98
     *   - 2600:3c00::5e
     *   - 2600:3c00::5f
     *
     * @param string $domain            The domain to import.
     * @param string $remote_nameserver The remote nameserver that allows zone transfers (AXFR).
     *
     * @throws LinodeException
     */
    public function importDomain(string $domain, string $remote_nameserver): Domain;

    /**
     * Clones a Domain and all associated DNS records from a Domain that is registered in
     * Linode's DNS manager.
     *
     * @param int    $domainId ID of the Domain to clone.
     * @param string $domain   The new domain being created.
     *
     * @throws LinodeException
     */
    public function cloneDomain(int $domainId, string $domain): Domain;
}
