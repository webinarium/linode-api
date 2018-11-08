<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Repository\Profile;

use Linode\Entity\Profile\SSHKey;
use Linode\Repository\RepositoryInterface;

/**
 * SSH key repository.
 */
interface SSHKeyRepositoryInterface extends RepositoryInterface
{
    /**
     * @param array $parameters
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return SSHKey
     */
    public function add(array $parameters): SSHKey;

    /**
     * @param int   $id
     * @param array $parameters
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return SSHKey
     */
    public function update(int $id, array $parameters): SSHKey;

    /**
     * @param int $id
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function delete(int $id): void;
}
