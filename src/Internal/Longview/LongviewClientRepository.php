<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal\Longview;

use Linode\Entity\Entity;
use Linode\Entity\Longview\LongviewClient;
use Linode\Internal\AbstractRepository;
use Linode\Repository\Longview\LongviewClientRepositoryInterface;

class LongviewClientRepository extends AbstractRepository implements LongviewClientRepositoryInterface
{
    public function create(array $parameters): LongviewClient
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_POST, $this->getBaseUri(), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new LongviewClient($this->client, $json);
    }

    public function update(int $id, array $parameters): LongviewClient
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_PUT, sprintf('%s/%s', $this->getBaseUri(), $id), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new LongviewClient($this->client, $json);
    }

    public function delete(int $id): void
    {
        $this->client->api($this->client::REQUEST_DELETE, sprintf('%s/%s', $this->getBaseUri(), $id));
    }

    protected function getBaseUri(): string
    {
        return '/longview/clients';
    }

    protected function getSupportedFields(): array
    {
        return [
            LongviewClient::FIELD_LABEL,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new LongviewClient($this->client, $json);
    }
}
