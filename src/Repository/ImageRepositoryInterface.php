<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Repository;

use Linode\Entity\Image;

/**
 * Image repository.
 */
interface ImageRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a private gold-master Image from a Linode Disk. There is no
     * additional charge to store Images for Linode users.
     *
     * Images are limited to three per Account.
     *
     * @param array $parameters
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return Image
     */
    public function create(array $parameters): Image;

    /**
     * Updates a private Image that you have permission to `read_write`.
     *
     * @param string $id
     * @param array  $parameters
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return Image
     */
    public function update(string $id, array $parameters): Image;

    /**
     * Deletes a private Image you have permission to `read_write`.
     *
     * WARNING! Deleting an Image is a destructive action and cannot be undone.
     *
     * @param string $id
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function delete(string $id): void;
}
