<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Networking;

use Linode\Exception\LinodeException;
use Linode\RepositoryInterface;

/**
 * FirewallDevices repository.
 *
 * @method FirewallDevices   find(int|string $id)
 * @method FirewallDevices[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method FirewallDevices[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method FirewallDevices   findOneBy(array $criteria)
 * @method FirewallDevices[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface FirewallDevicesRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a Firewall Device, which assigns a Firewall to a service (referred to
     * as the Device's `entity`) and applies the Firewall's Rules to the device.
     *
     * * Currently, Devices with `linode` and `nodebalancer` entity types are accepted.
     *
     * * Firewalls only apply to inbound TCP traffic to NodeBalancers.
     *
     * * A Firewall can be assigned to multiple services at a time.
     *
     * * A service can have one active, assigned Firewall at a time.
     * Additional disabled Firewalls can be assigned to a service, but they cannot be
     * enabled if another active Firewall is already assigned to the same service.
     *
     * * Assigned Linodes must not have any ongoing live migrations.
     *
     * * A `firewall_device_add` Event is generated when the Firewall Device is added
     * successfully.
     *
     * @throws LinodeException
     */
    public function createFirewallDevice(array $parameters = []): FirewallDevices;

    /**
     * Removes a Firewall Device, which removes a Firewall from the service it was
     * assigned to by the Device. This removes all of the Firewall's Rules from the
     * service. If any other Firewalls have been assigned to the service, then those
     * Rules
     * remain in effect.
     *
     * * Assigned Linodes must not have any ongoing live migrations.
     *
     * * A `firewall_device_remove` Event is generated when the Firewall Device is
     * removed successfully.
     *
     * @param int $deviceId ID of the Firewall Device to access.
     *
     * @throws LinodeException
     */
    public function deleteFirewallDevice(int $deviceId): void;

    /**
     * Returns the inbound and outbound Rules for a Firewall.
     *
     * @return FirewallRules The requested Firewall Rules.
     *
     * @throws LinodeException
     */
    public function getFirewallRules(): FirewallRules;

    /**
     * Updates the inbound and outbound Rules for a Firewall.
     *
     * * Assigned Linodes must not have any ongoing live migrations.
     *
     * * **Note:** This command replaces all of a Firewall's `inbound` and `outbound`
     * rulesets with the values specified in your request.
     *
     * @param array $parameters The Firewall Rules information to update.
     *
     * @return FirewallRules The updated Firewall Rules.
     *
     * @throws LinodeException
     */
    public function updateFirewallRules(array $parameters = []): FirewallRules;
}
