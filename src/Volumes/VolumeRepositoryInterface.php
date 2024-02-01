<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Volumes;

use Linode\Exception\LinodeException;
use Linode\RepositoryInterface;

/**
 * Volume repository.
 *
 * @method Volume   find(int|string $id)
 * @method Volume[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Volume[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Volume   findOneBy(array $criteria)
 * @method Volume[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface VolumeRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a Volume on your Account. In order for this to complete successfully, your
     * User must have the `add_volumes` grant. Creating a new Volume will start accruing
     * additional charges on your account.
     *
     * @param array $parameters The requested initial state of a new Volume.
     *
     * @throws LinodeException
     */
    public function createVolume(array $parameters = []): Volume;

    /**
     * Updates a Volume that you have permission to `read_write`.
     *
     * @param int   $volumeId   ID of the Volume to look up.
     * @param array $parameters If any updated field fails to pass validation, the Volume will not be updated.
     *
     * @throws LinodeException
     */
    public function updateVolume(int $volumeId, array $parameters = []): Volume;

    /**
     * Deletes a Volume you have permission to `read_write`.
     *
     * * **Deleting a Volume is a destructive action and cannot be undone.**
     *
     * * Deleting stops billing for the Volume. You will be billed for time used within
     * the billing period the Volume was active.
     *
     * * Volumes that are migrating cannot be deleted until the migration is finished.
     *
     * @param int $volumeId ID of the Volume to look up.
     *
     * @throws LinodeException
     */
    public function deleteVolume(int $volumeId): void;

    /**
     * Attaches a Volume on your Account to an existing Linode on your Account. In order
     * for this request to complete successfully, your User must have `read_only` or
     * `read_write` permission to the Volume and `read_write` permission to the Linode.
     * Additionally, the Volume and Linode must be located in the same Region.
     *
     * @param int   $volumeId   ID of the Volume to attach.
     * @param array $parameters Volume to attach to a Linode.
     *
     * @throws LinodeException
     */
    public function attachVolume(int $volumeId, array $parameters = []): Volume;

    /**
     * Creates a Volume on your Account. In order for this request to complete
     * successfully, your User must have the `add_volumes` grant. The new Volume will
     * have the same size and data as the source Volume. Creating a new Volume will incur
     * a charge on your Account.
     * * Only Volumes with a `status` of "active" can be cloned.
     *
     * @param int   $volumeId   ID of the Volume to clone.
     * @param array $parameters The requested state your Volume will be cloned into.
     *
     * @throws LinodeException
     */
    public function cloneVolume(int $volumeId, array $parameters = []): Volume;

    /**
     * Detaches a Volume on your Account from a Linode on your Account. In order for this
     * request to complete successfully, your User must have `read_write` access to the
     * Volume and `read_write` access to the Linode.
     *
     * @param int $volumeId ID of the Volume to detach.
     *
     * @throws LinodeException
     */
    public function detachVolume(int $volumeId): void;

    /**
     * Resize an existing Volume on your Account. In order for this request to complete
     * successfully, your User must have the `read_write` permissions to the Volume.
     * * Volumes can only be resized up.
     * * Only Volumes with a `status` of "active" can be resized.
     *
     * @param int   $volumeId   ID of the Volume to resize.
     * @param array $parameters The requested size to increase your Volume to.
     *
     * @throws LinodeException
     */
    public function resizeVolume(int $volumeId, array $parameters = []): void;
}
