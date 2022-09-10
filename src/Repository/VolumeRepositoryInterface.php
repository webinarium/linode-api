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

use Linode\Entity\Volume;

/**
 * Volume repository.
 */
interface VolumeRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a Volume on your Account. In order for this to complete successfully,
     * your User must have the `add_volumes` grant. Creating a new Volume will start
     * accruing additional charges on your account.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function create(array $parameters): Volume;

    /**
     * Updates a Volume that you have permission to `read_write`.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function update(int $id, array $parameters): Volume;

    /**
     * Deletes a Volume you have permission to `read_write`.
     *
     * WARNING! Deleting a Volume is a destructive action and cannot be undone.
     *
     * Deleting stops billing for the Volume. You will be billed for time used within
     * the billing period the Volume was active.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function delete(int $id): void;

    /**
     * Creates a Volume on your Account. In order for this request to complete
     * successfully, your User must have the `add_volumes` grant. The new Volume
     * will have the same size and data as the source Volume. Creating a new
     * Volume will incur a charge on your Account.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function clone(int $id, array $parameters): void;

    /**
     * Resize an existing Volume on your Account. In order for this request
     * to complete successfully, your User must have the `read_write`
     * permissions to the Volume.
     *
     * WARNING! Volumes can only be resized up.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function resize(int $id, array $parameters): void;

    /**
     * Attaches a Volume on your Account to an existing Linode on your Account.
     * In order for this request to complete successfully, your User must have
     * `read_only` or `read_write` permission to the Volume and `read_write`
     * permission to the Linode. Additionally, the Volume and Linode must be
     * located in the same Region.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function attach(int $id, array $parameters): Volume;

    /**
     * Detaches a Volume on your Account from a Linode on your Account. In order
     * for this request to complete successfully, your User must have `read_write`
     * access to the Volume and `read_write` access to the Linode.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function detach(int $id): void;
}
