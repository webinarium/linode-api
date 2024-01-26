<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Longview;

use Linode\Exception\LinodeException;
use Linode\RepositoryInterface;

/**
 * LongviewClient repository.
 *
 * @method LongviewClient   find(int|string $id)
 * @method LongviewClient[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method LongviewClient[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method LongviewClient   findOneBy(array $criteria)
 * @method LongviewClient[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface LongviewClientRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a Longview Client. This Client will not begin monitoring the status of
     * your server until you configure the Longview Client application on your Linode
     * using the returning `install_code` and `api_key`.
     *
     * @param array $parameters Information about the LongviewClient to create.
     *
     * @throws LinodeException
     */
    public function createLongviewClient(array $parameters = []): LongviewClient;

    /**
     * Updates a Longview Client. This cannot update how it monitors your server; use the
     * Longview Client application on your Linode for monitoring configuration.
     *
     * @param int   $clientId   The Longview Client ID to access.
     * @param array $parameters The fields to update.
     *
     * @throws LinodeException
     */
    public function updateLongviewClient(int $clientId, array $parameters = []): LongviewClient;

    /**
     * Deletes a Longview Client from your Account.
     *
     * **All information stored for this client will be lost.**
     *
     * This _does not_ uninstall the Longview Client application for your Linode - you
     * must do that manually.
     *
     * @param int $clientId The Longview Client ID to access.
     *
     * @throws LinodeException
     */
    public function deleteLongviewClient(int $clientId): void;
}
