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
     * Creates a Firewall Device, which assigns a Firewall to a Linode service (referred
     * to
     * as the Device's `entity`). Currently, only Devices with an entity of type `linode`
     * are accepted.
     * A Firewall can be assigned to multiple Linode services, and up to five active
     * Firewalls can
     * be assigned to a single Linode service. Additional disabled Firewalls can be
     * assigned to a service, but they cannot be enabled if five other active Firewalls
     * are already assigned to the same service.
     *
     * Creating a Firewall Device will apply the Rules from a Firewall to a Linode
     * service.
     * A `firewall_device_add` Event is generated when the Firewall Device is added
     * successfully.
     *
     * **Note:** When a Firewall is assigned to a Linode and you attempt
     * to migrate the Linode to a data center that does not support Cloud Firewalls, the
     * migration will fail.
     * Use the List Regions endpoint to view a list of a data center's capabilities.
     *
     * This endpoint is in **beta**.
     *
     *
     * * Gain access to Linode Cloud Firewall by signing up for our Greenlight Beta
     * program.
     * * During the beta, Cloud Firewall is not available in every data center region.
     * For the current list of availability, see the Cloud Firewall Product
     * Documentation.
     * * Please make sure to prepend all requests with
     * `/v4beta` instead of `/v4`, and be aware that this endpoint may receive breaking
     * updates in the future. This notice will be removed when this endpoint is out of
     * beta.
     *
     * @throws LinodeException
     */
    public function createFirewallDevice(array $parameters = []): FirewallDevices;

    /**
     * Removes a Firewall Device, which removes a Firewall from the Linode service it was
     * assigned to by the Device. This will remove all of the Firewall's Rules from the
     * Linode
     * service. If any other Firewalls have been assigned to the Linode service, then
     * those Rules
     * will remain in effect.
     *
     * A `firewall_device_remove` Event is generated when the Firewall Device is removed
     * successfully.
     *
     * This endpoint is in **beta**.
     *
     *
     * * Gain access to Linode Cloud Firewall by signing up for our Greenlight Beta
     * program.
     * * During the beta, Cloud Firewall is not available in every data center region.
     * For the current list of availability, see the Cloud Firewall Product
     * Documentation.
     * * Please make sure to prepend all requests with
     * `/v4beta` instead of `/v4`, and be aware that this endpoint may receive breaking
     * updates in the future. This notice will be removed when this endpoint is out of
     * beta.
     *
     * @param int $deviceId ID of the Firewall Device to access.
     *
     * @throws LinodeException
     */
    public function deleteFirewallDevice(int $deviceId): void;

    /**
     * Returns the inbound and outbound Rules for a Firewall.
     *
     * This endpoint is in **beta**.
     *
     *
     * * Gain access to Linode Cloud Firewall by signing up for our Greenlight Beta
     * program.
     * * During the beta, Cloud Firewall is not available in every data center region.
     * For the current list of availability, see the Cloud Firewall Product
     * Documentation.
     * * Please make sure to prepend all requests with
     * `/v4beta` instead of `/v4`, and be aware that this endpoint may receive breaking
     * updates in the future. This notice will be removed when this endpoint is out of
     * beta.
     *
     * @return FirewallRules The requested Firewall Rules.
     *
     * @throws LinodeException
     */
    public function getFirewallRules(): FirewallRules;

    /**
     * Updates the inbound and outbound Rules for a Firewall. Using this endpoint will
     * replace all of a Firewall's ruleset with the Rules specified in your request.
     *
     * This endpoint is in **beta**.
     *
     *
     * * Gain access to Linode Cloud Firewall by signing up for our Greenlight Beta
     * program.
     * * During the beta, Cloud Firewall is not available in every data center region.
     * For the current list of availability, see the Cloud Firewall Product
     * Documentation.
     * * Please make sure to prepend all requests with
     * `/v4beta` instead of `/v4`, and be aware that this endpoint may receive breaking
     * updates in the future. This notice will be removed when this endpoint is out of
     * beta.
     *
     * @param array $parameters The Firewall Rules information to update.
     *
     * @return FirewallRules The updated Firewall Rules.
     *
     * @throws LinodeException
     */
    public function updateFirewallRules(array $parameters = []): FirewallRules;
}
