<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal\Networking;

use Linode\Entity\Entity;
use Linode\Entity\Networking\IPAddress;
use Linode\Internal\AbstractRepository;
use Linode\Repository\Networking\IPAddressRepositoryInterface;

class IPAddressRepository extends AbstractRepository implements IPAddressRepositoryInterface
{
    public function allocate(int $linode_id, bool $public, string $type = IPAddress::TYPE_IP4): IPAddress
    {
        $parameters = [
            'linode_id' => $linode_id,
            'public'    => $public,
            'type'      => $type,
        ];

        $response = $this->client->api($this->client::REQUEST_POST, $this->getBaseUri(), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new IPAddress($this->client, $json);
    }

    public function update(string $id, array $parameters): IPAddress
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_PUT, sprintf('%s/%s', $this->getBaseUri(), $id), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new IPAddress($this->client, $json);
    }

    public function assign(string $region, array $assignments): void
    {
        $parameters = [
            'region'      => $region,
            'assignments' => $assignments,
        ];

        $this->client->api($this->client::REQUEST_POST, '/networking/ipv4/assign', $parameters);
    }

    public function share(int $linode_id, array $ips): void
    {
        $parameters = [
            'linode_id' => $linode_id,
            'ips'       => $ips,
        ];

        $this->client->api($this->client::REQUEST_POST, '/networking/ipv4/share', $parameters);
    }

    protected function getBaseUri(): string
    {
        return '/networking/ips';
    }

    protected function getSupportedFields(): array
    {
        return [
            IPAddress::FIELD_ADDRESS,
            IPAddress::FIELD_GATEWAY,
            IPAddress::FIELD_SUBNET_MASK,
            IPAddress::FIELD_PREFIX,
            IPAddress::FIELD_TYPE,
            IPAddress::FIELD_PUBLIC,
            IPAddress::FIELD_RDNS,
            IPAddress::FIELD_REGION,
            IPAddress::FIELD_LINODE_ID,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new IPAddress($this->client, $json);
    }
}
