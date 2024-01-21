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
use Linode\Entity\NodeBalancers\NodeBalancerNode;
use Linode\Internal\AbstractRepository;
use Linode\LinodeClient;
use Linode\Repository\NodeBalancers\NodeBalancerNodeRepositoryInterface;

/**
 * {@inheritdoc}
 */
class NodeBalancerNodeRepository extends AbstractRepository implements NodeBalancerNodeRepositoryInterface
{
    /**
     * {@inheritdoc}
     *
     * @param int $nodeBalancerId       The ID of the NodeBalancer we are accessing nodes for
     * @param int $nodeBalancerConfigId The ID of the NodeBalancer config we are accessing nodes for
     */
    public function __construct(LinodeClient $client, protected int $nodeBalancerId, protected int $nodeBalancerConfigId)
    {
        parent::__construct($client);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $parameters): NodeBalancerNode
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_POST, $this->getBaseUri(), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new NodeBalancerNode($this->client, $json);
    }

    /**
     * {@inheritdoc}
     */
    public function update(int $id, array $parameters): NodeBalancerNode
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_PUT, sprintf('%s/%s', $this->getBaseUri(), $id), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new NodeBalancerNode($this->client, $json);
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
    protected function getBaseUri(): string
    {
        return sprintf('/nodebalancers/%s/configs/%s/nodes', $this->nodeBalancerId, $this->nodeBalancerConfigId);
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedFields(): array
    {
        return [
            NodeBalancerNode::FIELD_ID,
            NodeBalancerNode::FIELD_LABEL,
            NodeBalancerNode::FIELD_ADDRESS,
            NodeBalancerNode::FIELD_STATUS,
            NodeBalancerNode::FIELD_WEIGHT,
            NodeBalancerNode::FIELD_MODE,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function jsonToEntity(array $json): Entity
    {
        return new NodeBalancerNode($this->client, $json);
    }
}
