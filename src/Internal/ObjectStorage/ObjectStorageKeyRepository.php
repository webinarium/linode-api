<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal\ObjectStorage;

use Linode\Entity\Entity;
use Linode\Entity\ObjectStorage\ObjectStorageKey;
use Linode\Internal\AbstractRepository;
use Linode\Repository\ObjectStorage\ObjectStorageKeyRepositoryInterface;

class ObjectStorageKeyRepository extends AbstractRepository implements ObjectStorageKeyRepositoryInterface
{
    public function create(array $parameters): ObjectStorageKey
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_POST, $this->getBaseUri(), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new ObjectStorageKey($this->client, $json);
    }

    public function update(int $id, array $parameters): ObjectStorageKey
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_PUT, sprintf('%s/%s', $this->getBaseUri(), $id), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new ObjectStorageKey($this->client, $json);
    }

    public function revoke(int $id): void
    {
        $this->client->api($this->client::REQUEST_DELETE, sprintf('%s/%s', $this->getBaseUri(), $id));
    }

    protected function getBaseUri(): string
    {
        return 'beta/object-storage/keys';
    }

    protected function getSupportedFields(): array
    {
        return [
            ObjectStorageKey::FIELD_ID,
            ObjectStorageKey::FIELD_LABEL,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new ObjectStorageKey($this->client, $json);
    }
}
