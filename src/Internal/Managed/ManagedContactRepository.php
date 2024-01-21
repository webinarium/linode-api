<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal\Managed;

use Linode\Entity\Entity;
use Linode\Entity\Managed\ManagedContact;
use Linode\Internal\AbstractRepository;
use Linode\Repository\Managed\ManagedContactRepositoryInterface;

class ManagedContactRepository extends AbstractRepository implements ManagedContactRepositoryInterface
{
    public function create(array $parameters): ManagedContact
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_POST, $this->getBaseUri(), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new ManagedContact($this->client, $json);
    }

    public function update(int $id, array $parameters): ManagedContact
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_PUT, sprintf('%s/%s', $this->getBaseUri(), $id), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new ManagedContact($this->client, $json);
    }

    public function delete(int $id): void
    {
        $this->client->api($this->client::REQUEST_DELETE, sprintf('%s/%s', $this->getBaseUri(), $id));
    }

    protected function getBaseUri(): string
    {
        return '/managed/contacts';
    }

    protected function getSupportedFields(): array
    {
        return [
            ManagedContact::FIELD_ID,
            ManagedContact::FIELD_NAME,
            ManagedContact::FIELD_EMAIL,
            ManagedContact::FIELD_PHONE,
            ManagedContact::FIELD_GROUP,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new ManagedContact($this->client, $json);
    }
}
