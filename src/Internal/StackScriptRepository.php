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
use Linode\Entity\StackScript;
use Linode\Repository\StackScriptRepositoryInterface;

class StackScriptRepository extends AbstractRepository implements StackScriptRepositoryInterface
{
    public function create(array $parameters): StackScript
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_POST, $this->getBaseUri(), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new StackScript($this->client, $json);
    }

    public function update(int $id, array $parameters): StackScript
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_PUT, sprintf('%s/%s', $this->getBaseUri(), $id), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new StackScript($this->client, $json);
    }

    public function delete(int $id): void
    {
        $this->client->api($this->client::REQUEST_DELETE, sprintf('%s/%s', $this->getBaseUri(), $id));
    }

    protected function getBaseUri(): string
    {
        return '/linode/stackscripts';
    }

    protected function getSupportedFields(): array
    {
        return [
            StackScript::FIELD_ID,
            StackScript::FIELD_USERNAME,
            StackScript::FIELD_LABEL,
            StackScript::FIELD_IMAGES,
            StackScript::FIELD_IS_PUBLIC,
            StackScript::FIELD_CREATED,
            StackScript::FIELD_UPDATED,
            StackScript::FIELD_USER_GRAVATAR_ID,
            StackScript::FIELD_DESCRIPTION,
            StackScript::FIELD_DEPLOYMENTS_TOTAL,
            StackScript::FIELD_DEPLOYMENTS_ACTIVE,
            StackScript::FIELD_REV_NOTE,
            StackScript::FIELD_SCRIPT,
            StackScript::FIELD_USER_DEFINED_FIELDS,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new StackScript($this->client, $json);
    }
}
