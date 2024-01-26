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
 *
 * @method Image   find(int|string $id)
 * @method Image[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Image[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Image   findOneBy(array $criteria)
 * @method Image[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface ImageRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a private gold-master Image from a Linode Disk. There is no additional
     * charge to store Images for Linode users.
     * Images are limited to three per Account.
     *
     * @param array $parameters Information about the Image to create.
     *
     * @throws LinodeException
     */
    public function createImage(array $parameters = []): Image;

    /**
     * Updates a private Image that you have permission to `read_write`.
     *
     * @param string $imageId    ID of the Image to look up.
     * @param array  $parameters The fields to update.
     *
     * @throws LinodeException
     */
    public function updateImage(string $imageId, array $parameters = []): Image;

    /**
     * Deletes a private Image you have permission to `read_write`.
     *
     * **Deleting an Image is a destructive action and cannot be undone.**
     *
     * @param string $imageId ID of the Image to look up.
     *
     * @throws LinodeException
     */
    public function deleteImage(string $imageId): void;
}
