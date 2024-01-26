<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\StackScripts;

use Linode\Exception\LinodeException;
use Linode\RepositoryInterface;

/**
 * StackScript repository.
 *
 * @method StackScript   find(int|string $id)
 * @method StackScript[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method StackScript[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method StackScript   findOneBy(array $criteria)
 * @method StackScript[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface StackScriptRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a StackScript in your Account.
     *
     * @param array $parameters The properties to set for the new StackScript.
     *
     * @throws LinodeException
     */
    public function addStackScript(array $parameters = []): StackScript;

    /**
     * Updates a StackScript.
     *
     * **Once a StackScript is made public, it cannot be made private.**
     *
     * @param int   $stackscriptId The ID of the StackScript to look up.
     * @param array $parameters    The fields to update.
     *
     * @throws LinodeException
     */
    public function updateStackScript(int $stackscriptId, array $parameters = []): StackScript;

    /**
     * Deletes a private StackScript you have permission to `read_write`. You cannot
     * delete a public StackScript.
     *
     * @param int $stackscriptId The ID of the StackScript to look up.
     *
     * @throws LinodeException
     */
    public function deleteStackScript(int $stackscriptId): void;
}
