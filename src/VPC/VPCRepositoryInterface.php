<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\VPC;

use Linode\Exception\LinodeException;
use Linode\RepositoryInterface;

/**
 * VPC repository.
 *
 * @method VPC   find(int|string $id)
 * @method VPC[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method VPC[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method VPC   findOneBy(array $criteria)
 * @method VPC[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface VPCRepositoryInterface extends RepositoryInterface
{
    /**
     * Create a new VPC and optionally associated VPC Subnets.
     * * Users must have the `add_vpc` grant to access this command.
     * * A successful request triggers a `vpc_create` event and `subnet_create` events
     * for any created VPC Subnets.
     *
     * Once a VPC is created, it can be attached to a Linode by assigning a VPC Subnet to
     * one of the Linode's Configuration Profile Interfaces. This step can be
     * accomplished with the following commands:
     * * Linode Create (POST /linode/instances)
     * * Configuration Profile Create (POST /linode/instances/{linodeId}/configs)
     * * Configuration Profile Update (PUT
     * /linode/instances/{linodeId}/configs/{configId})
     * * Configuration Profile Interface Add (POST
     * /linode/instances/{linodeId}/configs/{configId}/interfaces)
     *
     * @param array $parameters VPC Create request object.
     *
     * @throws LinodeException
     */
    public function createVPC(array $parameters = []): VPC;

    /**
     * Update an existing VPC.
     * * The User accessing this command must have `read_write` grants to the VPC.
     * * A successful request triggers a `vpc_update` event.
     *
     * To update a VPC's Subnet, use the VPC Subnet Update command.
     *
     * @param int   $vpcId      The `id` of the VPC.
     * @param array $parameters VPC Update request object.
     *
     * @throws LinodeException
     */
    public function updateVPC(int $vpcId, array $parameters = []): VPC;

    /**
     * Delete a single VPC and all of its Subnets.
     * * The User accessing this command must have `read_write` grants to the VPC.
     * * A successful request triggers a `vpc_delete` event and `subnet_delete` events
     * for each deleted VPC Subnet.
     * * All of the VPC's Subnets must be eligible for deletion. Accordingly, all
     * Configuration Profile Interfaces that each Subnet is assigned to must first be
     * deleted. If those Interfaces are active, the associated Linodes must first be shut
     * down before they can be removed. If any Subnet cannot be deleted, then neither the
     * VPC nor any of its Subnets are deleted.
     *
     * @param int $vpcId The `id` of the VPC.
     *
     * @throws LinodeException
     */
    public function deleteVPC(int $vpcId): void;
}
