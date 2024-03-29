<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Networking\Repository;

use Linode\Entity;
use Linode\Internal\AbstractRepository;
use Linode\LinodeClient;
use Linode\Networking\FirewallDevices;
use Linode\Networking\FirewallDevicesRepositoryInterface;
use Linode\Networking\FirewallRules;

/**
 * @codeCoverageIgnore This class was autogenerated.
 */
class FirewallDevicesRepository extends AbstractRepository implements FirewallDevicesRepositoryInterface
{
    /**
     * @param int $firewallId ID of the Firewall to access.
     */
    public function __construct(LinodeClient $client, protected int $firewallId)
    {
        parent::__construct($client);
    }

    public function createFirewallDevice(array $parameters = []): FirewallDevices
    {
        $response = $this->client->post($this->getBaseUri(), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new FirewallDevices($this->client, $json);
    }

    public function deleteFirewallDevice(int $deviceId): void
    {
        $this->client->delete(sprintf('%s/%s', $this->getBaseUri(), $deviceId));
    }

    public function getFirewallRules(): FirewallRules
    {
        $response = $this->client->get(sprintf('/networking/firewalls/%s/rules', $this->getBaseUri()));
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new FirewallRules($this->client, $json);
    }

    public function updateFirewallRules(array $parameters = []): FirewallRules
    {
        $response = $this->client->put(sprintf('/networking/firewalls/%s/rules', $this->getBaseUri()), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new FirewallRules($this->client, $json);
    }

    protected function getBaseUri(): string
    {
        return sprintf('/networking/firewalls/%s/devices', $this->firewallId);
    }

    protected function getSupportedFields(): array
    {
        return [
            FirewallDevices::FIELD_ID,
            FirewallDevices::FIELD_CREATED,
            FirewallDevices::FIELD_UPDATED,
            FirewallDevices::FIELD_ENTITY,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new FirewallDevices($this->client, $json);
    }
}
