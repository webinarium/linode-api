<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Account;

use Linode\Exception\LinodeException;
use Linode\RepositoryInterface;

/**
 * EntityTransfer repository.
 *
 * @method EntityTransfer   find(int|string $id)
 * @method EntityTransfer[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method EntityTransfer[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method EntityTransfer   findOneBy(array $criteria)
 * @method EntityTransfer[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface EntityTransferRepositoryInterface extends RepositoryInterface
{
    /**
     * **DEPRECATED**. Please use Service Transfer Create.
     *
     * @param array $parameters The entities to include in this transfer request.
     *
     * @throws LinodeException
     */
    public function createEntityTransfer(array $parameters = []): EntityTransfer;

    /**
     * **DEPRECATED**. Please use Service Transfer Cancel.
     *
     * @param string $token The UUID of the Entity Transfer.
     *
     * @throws LinodeException
     */
    public function deleteEntityTransfer(string $token): void;

    /**
     * **DEPRECATED**. Please use Service Transfer Accept.
     *
     * @param string $token The UUID of the Entity Transfer.
     *
     * @throws LinodeException
     */
    public function acceptEntityTransfer(string $token): void;
}
