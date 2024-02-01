<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Account;

use Linode\Exception\LinodeException;
use Linode\RepositoryInterface;

/**
 * EntityTransfer repository.
 *
 * @method EntityTransfer   find(int|string $id)
 * @method EntityTransfer[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method EntityTransfer[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method EntityTransfer   findOneBy(array $criteria)
 * @method EntityTransfer[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface EntityTransferRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a transfer request for the specified entities. A request can contain any
     * of the specified entity types and any number of each entity type. At this time,
     * only Linodes can be transferred.
     *
     * When created successfully, a confirmation email is sent to the account that
     * created this transfer containing a transfer token and instructions on completing
     * the transfer.
     *
     * When a transfer is accepted, the requested entities are moved to the receiving
     * account. Linode services will not experience interruptions due to the transfer
     * process, but please take note of the following:
     *
     * - If any of the Linodes included in the request have Backups enabled, that data
     * and associated costs will be removed/cancelled.
     * - DNS records will not be transferred or updated. Please ensure that DNS records
     * have been updated or communicated to the recipient prior to the transfer.
     *
     * A transfer can take up to three hours to complete once accepted. When a transfer
     * is completed, billing for transferred entities ends for the sending account and
     * begins for the receiving account.
     *
     * This command can only be accessed by the unrestricted users of an account.
     *
     * There are several conditions that must be met in order to successfully create a
     * transfer request:
     * 1. The account creating the transfer must not have a past due balance or active
     * Terms of Service violation.
     * 1. The entity must be owned by the account that is creating the transfer.
     * 1. The entity must not be assigned to another Entity Transfer that is pending or
     * that has been accepted and is incomplete.
     * 1. Linodes must not:
     *
     *     * be assigned to a NodeBalancer, Firewall, or Managed Service.
     *
     *     * have any attached Block Storage Volumes.
     *
     *     * have any shared IP addresses.
     *
     *     * have any assigned /56, /64, or /116 IPv6 ranges.
     *
     * @param array $parameters The entities to include in this transfer request.
     *
     * @throws LinodeException
     */
    public function createEntityTransfer(array $parameters = []): EntityTransfer;

    /**
     * Cancels the Entity Transfer for the provided token. Once cancelled, a transfer
     * cannot be accepted or otherwise acted on in any way. If cancelled in error, the
     * transfer must be created again.
     *
     * When cancelled, an email notification for the cancellation is sent to the account
     * that created this transfer. Transfers can not be cancelled if they are expired or
     * have been accepted.
     *
     * This command can only be accessed by the unrestricted users of the account that
     * created this transfer.
     *
     * @param string $token The UUID of the Entity Transfer.
     *
     * @throws LinodeException
     */
    public function deleteEntityTransfer(string $token): void;

    /**
     * Accept an Entity Transfer for the provided token to receive the entities included
     * in the transfer to your account. At this time, only Linodes can be transferred.
     *
     * When accepted, email confirmations are sent to the accounts that created and
     * accepted the transfer. A transfer can take up to three hours to complete once
     * accepted. Once a transfer is completed, billing for transferred entities ends for
     * the sending account and begins for the receiving account.
     *
     * This command can only be accessed by the unrestricted users of the account that
     * receives the transfer. Users of the same account that created a transfer cannot
     * accept the transfer.
     *
     * There are several conditions that must be met in order to accept a transfer
     * request:
     * 1. Only transfers with a `pending` status can be accepted.
     * 1. The account accepting the transfer must have a registered payment method and
     * must not have a past due
     *   balance or other account limitations for the entities to be transferred.
     * 1. Both the account that created the transfer and the account that is accepting
     * the transfer must not have any active Terms of Service violations.
     * 1. The entity must still be owned by the account that created the transfer.
     * 1. Linodes must not:
     *
     *     * be assigned to a NodeBalancer, Firewall, or Managed Service.
     *
     *     * have any attached Block Storage Volumes.
     *
     *     * have any shared IP addresses.
     *
     *     * have any assigned /56, /64, or /116 IPv6 ranges.
     * Any and all of the above conditions must be cured and maintained by the relevant
     * account prior to the transfer's expiration to allow the transfer to be accepted by
     * the receiving account.
     *
     * @param string $token The UUID of the Entity Transfer.
     *
     * @throws LinodeException
     */
    public function acceptEntityTransfer(string $token): void;
}
