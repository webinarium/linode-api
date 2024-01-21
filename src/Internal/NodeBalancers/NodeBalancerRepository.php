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
use Linode\Entity\NodeBalancers\NodeBalancerStats;
use Linode\Internal\AbstractRepository;
use Linode\Repository\NodeBalancers\NodeBalancerRepositoryInterface;

/**
 * {@inheritdoc}
 */
class NodeBalancerRepository extends AbstractRepository implements NodeBalancerRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(array $parameters): NodeBalancer
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_POST, $this->getBaseUri(), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new NodeBalancer($this->client, $json);
    }

    /**
     * {@inheritdoc}
     */
    public function update(int $id, array $parameters): NodeBalancer
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_PUT, sprintf('%s/%s', $this->getBaseUri(), $id), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new NodeBalancer($this->client, $json);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(int $id): void
    {
        $this->client->api($this->client::REQUEST_DELETE, sprintf('%s/%s', $this->getBaseUri(), $id));
    }

    /**
     * {@inheritdoc}
     */
    public function getStats(int $id): NodeBalancerStats
    {
        $response = $this->client->api($this->client::REQUEST_GET, sprintf('%s/%s/stats', $this->getBaseUri(), $id));
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new NodeBalancerStats($this->client, $json);
    }

    /**
     * {@inheritdoc}
     */
    protected function getBaseUri(): string
    {
        return '/nodebalancers';
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedFields(): array
    {
        return [
            NodeBalancer::FIELD_ID,
            NodeBalancer::FIELD_LABEL,
            NodeBalancer::FIELD_REGION,
            NodeBalancer::FIELD_HOSTNAME,
            NodeBalancer::FIELD_IPV4,
            NodeBalancer::FIELD_IPV6,
            NodeBalancer::FIELD_CLIENT_CONN_THROTTLE,
            NodeBalancer::FIELD_CONFIGS,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function jsonToEntity(array $json): Entity
    {
        return new NodeBalancer($this->client, $json);
    }
}
