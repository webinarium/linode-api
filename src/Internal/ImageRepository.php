<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal;

use Linode\Entity\Entity;
use Linode\Entity\Image;
use Linode\Repository\ImageRepositoryInterface;

/**
 * {@inheritdoc}
 */
class ImageRepository extends AbstractRepository implements ImageRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(array $parameters): Image
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_POST, $this->getBaseUri(), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Image($this->client, $json);
    }

    /**
     * {@inheritdoc}
     */
    public function update(string $id, array $parameters): Image
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_PUT, sprintf('%s/%s', $this->getBaseUri(), $id), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Image($this->client, $json);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(string $id): void
    {
        $this->client->api($this->client::REQUEST_DELETE, sprintf('%s/%s', $this->getBaseUri(), $id));
    }

    /**
     * {@inheritdoc}
     */
    protected function getBaseUri(): string
    {
        return '/images';
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedFields(): array
    {
        return [
            Image::FIELD_ID,
            Image::FIELD_LABEL,
            Image::FIELD_VENDOR,
            Image::FIELD_DESCRIPTION,
            Image::FIELD_IS_PUBLIC,
            Image::FIELD_SIZE,
            Image::FIELD_TYPE,
            Image::FIELD_DEPRECATED,
            Image::FIELD_DISK_ID,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function jsonToEntity(array $json): Entity
    {
        return new Image($this->client, $json);
    }
}
