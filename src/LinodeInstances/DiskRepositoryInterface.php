<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\LinodeInstances;

use Linode\Exception\LinodeException;
use Linode\RepositoryInterface;

/**
 * Disk repository.
 *
 * @method Disk   find(int|string $id)
 * @method Disk[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Disk[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Disk   findOneBy(array $criteria)
 * @method Disk[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface DiskRepositoryInterface extends RepositoryInterface
{
    /**
     * Adds a new Disk to a Linode. You can optionally create a Disk from an Image (see
     * /images for a list of available public images, or use one of your own), and
     * optionally provide a StackScript to deploy with this Disk.
     *
     * @param array $parameters The parameters to set when creating the Disk.
     *
     * @throws LinodeException
     */
    public function addLinodeDisk(array $parameters = []): Disk;

    /**
     * Updates a Disk that you have permission to `read_write`.
     *
     * @param int   $diskId     ID of the Disk to look up.
     * @param array $parameters Updates the parameters of a single Disk.
     *
     * @throws LinodeException
     */
    public function updateDisk(int $diskId, array $parameters = []): Disk;

    /**
     * Deletes a Disk you have permission to `read_write`.
     *
     * **Deleting a Disk is a destructive action and cannot be undone.**
     *
     * @param int $diskId ID of the Disk to look up.
     *
     * @throws LinodeException
     */
    public function deleteDisk(int $diskId): void;

    /**
     * Copies a disk, byte-for-byte, into a new Disk belonging to the same Linode. The
     * Linode must have enough storage space available to accept a new Disk of the same
     * size as this one or this operation will fail.
     *
     * @param int $diskId ID of the Disk to clone.
     *
     * @throws LinodeException
     */
    public function cloneLinodeDisk(int $diskId): Disk;

    /**
     * Resets the password of a Disk you have permission to `read_write`.
     *
     * @param int    $diskId   ID of the Disk to look up.
     * @param string $password The new root password for the OS installed on this Disk.
     *
     * @throws LinodeException
     */
    public function resetDiskPassword(int $diskId, string $password): void;

    /**
     * Resizes a Disk you have permission to `read_write`.
     * The Linode this Disk is attached to must be shut down for resizing to take effect.
     * If you are resizing the Disk to a smaller size, it cannot be made smaller than
     * what is required by the total size of the files current on the Disk. The Disk must
     * not be in use. If the Disk is in use, the request will succeed but the resize will
     * ultimately fail.
     *
     * @param int $diskId ID of the Disk to look up.
     * @param int $size   The desired size, in MB, of the disk.
     *
     * @throws LinodeException
     */
    public function resizeDisk(int $diskId, int $size): void;
}
