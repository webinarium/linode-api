<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Repository\Linode;

use Linode\Entity\Linode\Disk;
use Linode\Repository\RepositoryInterface;

/**
 * Linode disk repository.
 */
interface DiskRepositoryInterface extends RepositoryInterface
{
    /**
     * Adds a new Disk to a Linode. You can optionally create a Disk from
     * an Image for a list of available public images, or use one of your own),
     * and optionally provide a StackScript to deploy with this Disk.
     *
     * @param array $parameters
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return Disk
     */
    public function create(array $parameters): Disk;

    /**
     * Updates a Disk that you have permission to `read_write`.
     *
     * @param int   $id
     * @param array $parameters
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return Disk
     */
    public function update(int $id, array $parameters): Disk;

    /**
     * Deletes a Disk you have permission to `read_write`.
     *
     * WARNING! Deleting a Disk is a destructive action and cannot be undone.
     *
     * @param int $id
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function delete(int $id): void;

    /**
     * Resizes a Disk you have permission to `read_write`.
     *
     * The Linode this Disk is attached to must be shut down for resizing to
     * take effect.
     *
     * If you are resizing the Disk to a smaller size, it cannot be made smaller
     * than what is required by the total size of the files current on the Disk.
     * The Disk must not be in use. If the Disk is in use, the request will
     * succeed but the resize will ultimately fail.
     *
     * @param int $id
     * @param int $size
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function resize(int $id, int $size): void;

    /**
     * Resets the password of a Disk you have permission to `read_write`.
     *
     * @param int    $id
     * @param string $password
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function resetPassword(int $id, string $password): void;
}
