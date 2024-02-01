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
     * Captures a private gold-master Image from a Linode Disk.
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

    /**
     * Initiates an Image upload.
     *
     * This endpoint creates a new private Image object and returns it along
     * with the URL to which image data can be uploaded.
     *
     * - Image data must be uploaded within 24 hours of creation or the
     * upload will be cancelled and the image deleted.
     *
     * - Image uploads should be made as an HTTP PUT request to the URL returned in the
     * `upload_to`
     * response parameter, with a `Content-type: application/octet-stream` header
     * included in the
     * request. For example:
     *
     *       curl -v \
     *         -H "Content-Type: application/octet-stream" \
     *         --upload-file example.img.gz \
     *         $UPLOAD_URL \
     *         --progress-bar \
     *         --output /dev/null
     *
     * - Uploaded image data should be compressed in gzip (`.gz`) format. The
     * uncompressed disk should be in raw
     * disk image (`.img`) format. A maximum compressed file size of 5GB is supported for
     * upload at this time.
     *
     * **Note:** To initiate and complete an Image upload in a single step, see our guide
     * on how to Upload an Image using Cloud Manager or the Linode CLI `image-upload`
     * plugin.
     *
     * @param array $parameters The uploaded Image details.
     *
     * @return Image Uploaded Image.
     *
     * @throws LinodeException
     */
    public function uploadImage(array $parameters = []): Image;
}
