<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal\Tags;

use Linode\Entity\Entity;
use Linode\Entity\Tag;
use Linode\Internal\AbstractRepository;
use Linode\Repository\Tags\TagRepositoryInterface;

/**
 * {@inheritdoc}
 */
class TagRepository extends AbstractRepository implements TagRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(array $parameters): Tag
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_POST, $this->getBaseUri(), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Tag($this->client, $json);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(string $label): void
    {
        $this->client->api($this->client::REQUEST_DELETE, sprintf('%s/%s', $this->getBaseUri(), $label));
    }

    /**
     * {@inheritdoc}
     */
    protected function getBaseUri(): string
    {
        return '/tags';
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedFields(): array
    {
        return [
            Tag::FIELD_LABEL,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function jsonToEntity(array $json): Entity
    {
        return new Tag($this->client, $json);
    }
}
