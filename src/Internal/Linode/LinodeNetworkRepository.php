<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal\Linode;

use Linode\Entity\Linode;
use Linode\Entity\Networking\IPAddress;
use Linode\LinodeClient;
use Linode\Repository\Linode\LinodeNetworkRepositoryInterface;

/**
 * {@inheritdoc}
 */
class LinodeNetworkRepository implements LinodeNetworkRepositoryInterface
{
    /**
     * {@inheritdoc}
     *
     * @param int $linodeId ID of the Linode to look up
     */
    public function __construct(protected LinodeClient $client, protected int $linodeId)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getNetworkInformation(): Linode\NetworkInformation
    {
        $response = $this->client->api($this->client::REQUEST_GET, $this->getBaseUri());
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Linode\NetworkInformation($this->client, $json);
    }

    /**
     * {@inheritdoc}
     */
    public function find(string $id): IPAddress
    {
        $response = $this->client->api($this->client::REQUEST_GET, sprintf('%s/%s', $this->getBaseUri(), $id));
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new IPAddress($this->client, $json);
    }

    /**
     * {@inheritdoc}
     */
    public function allocate(bool $public, string $type = IPAddress::TYPE_IP4): IPAddress
    {
        $parameters = [
            'public'    => $public,
            'type'      => $type,
        ];

        $response = $this->client->api($this->client::REQUEST_POST, $this->getBaseUri(), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new IPAddress($this->client, $json);
    }

    /**
     * {@inheritdoc}
     */
    public function update(string $id, array $parameters): IPAddress
    {
        $response = $this->client->api($this->client::REQUEST_PUT, sprintf('%s/%s', $this->getBaseUri(), $id), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new IPAddress($this->client, $json);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(string $id): void
    {
        $this->client->api($this->client::REQUEST_DELETE, sprintf('%s/%s', $this->getBaseUri(), $id));
    }

    /**
     * Returns base URI to the repository-specific API.
     */
    protected function getBaseUri(): string
    {
        return sprintf('/linode/instances/%s/ips', $this->linodeId);
    }
}
