<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Profile;

use Linode\Exception\LinodeException;
use Linode\RepositoryInterface;

/**
 * SSH key repository.
 */
interface SSHKeyRepositoryInterface extends RepositoryInterface
{
    /**
     * @throws LinodeException
     */
    public function add(array $parameters): SSHKey;

    /**
     * @throws LinodeException
     */
    public function update(int $id, array $parameters): SSHKey;

    /**
     * @throws LinodeException
     */
    public function delete(int $id): void;
}
