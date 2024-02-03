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
 * VPCSubnet repository.
 *
 * @method VPCSubnet   find(int|string $id)
 * @method VPCSubnet[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method VPCSubnet[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method VPCSubnet   findOneBy(array $criteria)
 * @method VPCSubnet[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface VPCSubnetRepositoryInterface extends RepositoryInterface
{
    /**
     * Create a VPC Subnet.
     * * The User accessing this command must have `read_write` grants to the VPC.
     * * A successful request triggers a `subnet_create` event.
     *
     * Once a VPC Subnet is created, it can be attached to a Linode by assigning the
     * Subnet to one of the Linode's Configuration Profile Interfaces. This step can be
     * accomplished with the following commands:
     * * Linode Create (POST /linode/instances)
     * * Configuration Profile Create (POST /linode/instances/{linodeId}/configs)
     * * Configuration Profile Update (PUT
     * /linode/instances/{linodeId}/configs/{configId})
     * * Configuration Profile Interface Add (POST
     * /linode/instances/{linodeId}/configs/{configId}/interfaces)
     *
     * @param array $parameters VPC Subnet Create request object.
     *
     * @throws LinodeException
     */
    public function createVPCSubnet(array $parameters = []): VPCSubnet;

    /**
     * Update a VPC Subnet.
     * * The User accessing this command must have `read_write` grants to the VPC.
     * * A successful request triggers a `subnet_update` event.
     *
     * @param int   $vpcSubnetId The `id` of the VPC Subnet.
     * @param array $parameters  VPC Update request object.
     *
     * @throws LinodeException
     */
    public function updateVPCSubnet(int $vpcSubnetId, array $parameters = []): VPCSubnet;

    /**
     * Delete a single VPC Subnet.
     *
     * The user accessing this command must have `read_write` grants to the VPC. A
     * successful request triggers a `subnet_delete` event.
     *
     * **Note:** You need to delete all the Configuration Profile Interfaces that this
     * Subnet is assigned to before you can delete it. If those Interfaces are active,
     * the associated Linode needs to be shut down before they can be removed.
     *
     * @param int $vpcSubnetId The `id` of the VPC Subnet.
     *
     * @throws LinodeException
     */
    public function deleteVPCSubnet(int $vpcSubnetId): void;
}
