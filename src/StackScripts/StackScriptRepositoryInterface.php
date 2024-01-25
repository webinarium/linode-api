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
 */
interface StackScriptRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a StackScript in your Account.
     *
     * @throws LinodeException
     */
    public function create(array $parameters): StackScript;

    /**
     * Updates a StackScript.
     *
     * @throws LinodeException
     */
    public function update(int $id, array $parameters): StackScript;

    /**
     * Deletes a private StackScript you have permission to `read_write`. You cannot delete a public StackScript.
     *
     * @throws LinodeException
     */
    public function delete(int $id): void;
}
