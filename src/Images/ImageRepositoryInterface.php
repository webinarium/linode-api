<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Images;

use Linode\Exception\LinodeException;
use Linode\RepositoryInterface;

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
     * @throws LinodeException
     */
    public function create(array $parameters): Image;

    /**
     * Updates a private Image that you have permission to `read_write`.
     *
     * @throws LinodeException
     */
    public function update(string $id, array $parameters): Image;

    /**
     * Deletes a private Image you have permission to `read_write`.
     *
     * WARNING! Deleting an Image is a destructive action and cannot be undone.
     *
     * @throws LinodeException
     */
    public function delete(string $id): void;
}
