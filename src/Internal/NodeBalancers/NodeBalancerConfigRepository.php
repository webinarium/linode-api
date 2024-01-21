<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal\NodeBalancers;

use Linode\Entity\Entity;
use Linode\Entity\NodeBalancers\NodeBalancer;
use Linode\Entity\NodeBalancers\NodeBalancerConfig;
use Linode\Internal\AbstractRepository;
use Linode\LinodeClient;
use Linode\Repository\NodeBalancers\NodeBalancerConfigRepositoryInterface;

class NodeBalancerConfigRepository extends AbstractRepository implements NodeBalancerConfigRepositoryInterface
{
    /**
     * @param int $nodeBalancerId The ID of the NodeBalancer we are accessing Configs for
     */
    public function __construct(LinodeClient $client, protected int $nodeBalancerId)
    {
        parent::__construct($client);
    }

    public function create(array $parameters): NodeBalancerConfig
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_POST, $this->getBaseUri(), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new NodeBalancerConfig($this->client, $json);
    }

    public function update(int $id, array $parameters): NodeBalancerConfig
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_PUT, sprintf('%s/%s', $this->getBaseUri(), $id), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new NodeBalancerConfig($this->client, $json);
    }

    public function delete(int $id): void
    {
        $this->client->api($this->client::REQUEST_DELETE, sprintf('%s/%s', $this->getBaseUri(), $id));
    }

    public function rebuild(int $id, array $parameters): NodeBalancer
    {
        $response = $this->client->api($this->client::REQUEST_POST, sprintf('%s/%s/rebuild', $this->getBaseUri(), $id), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new NodeBalancer($this->client, $json);
    }

    protected function getBaseUri(): string
    {
        return sprintf('/nodebalancers/%s/configs', $this->nodeBalancerId);
    }

    protected function getSupportedFields(): array
    {
        return [
            NodeBalancerConfig::FIELD_ID,
            NodeBalancerConfig::FIELD_PORT,
            NodeBalancerConfig::FIELD_PROTOCOL,
            NodeBalancerConfig::FIELD_ALGORITHM,
            NodeBalancerConfig::FIELD_STICKINESS,
            NodeBalancerConfig::FIELD_CHECK,
            NodeBalancerConfig::FIELD_CHECK_INTERVAL,
            NodeBalancerConfig::FIELD_CHECK_TIMEOUT,
            NodeBalancerConfig::FIELD_CHECK_ATTEMPTS,
            NodeBalancerConfig::FIELD_CHECK_PATH,
            NodeBalancerConfig::FIELD_CHECK_BODY,
            NodeBalancerConfig::FIELD_CHECK_PASSIVE,
            NodeBalancerConfig::FIELD_CIPHER_SUITE,
            NodeBalancerConfig::FIELD_SSL_COMMONNAME,
            NodeBalancerConfig::FIELD_SSL_FINGERPRINT,
            NodeBalancerConfig::FIELD_SSL_CERT,
            NodeBalancerConfig::FIELD_SSL_KEY,
            NodeBalancerConfig::FIELD_NODES,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new NodeBalancerConfig($this->client, $json);
    }
}
