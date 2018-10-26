<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal\Account;

use Linode\Entity\Account\User;
use Linode\Entity\Account\UserGrant;
use Linode\Entity\Entity;
use Linode\Internal\AbstractRepository;
use Linode\Repository\Account\UserRepositoryInterface;

/**
 * {@inheritdoc}
 */
class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(array $parameters): User
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_POST, $this->getBaseUri(), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new User($this->client, $json);
    }

    /**
     * {@inheritdoc}
     */
    public function update(string $username, array $parameters): User
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_PUT, sprintf('%s/%s', $this->getBaseUri(), $username), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new User($this->client, $json);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(string $username): void
    {
        $this->client->api($this->client::REQUEST_DELETE, sprintf('%s/%s', $this->getBaseUri(), $username));
    }

    /**
     * {@inheritdoc}
     */
    public function getUserGrants(string $username): ?UserGrant
    {
        $response = $this->client->api($this->client::REQUEST_GET, sprintf('%s/%s/grants', $this->getBaseUri(), $username));

        if ($response->getStatusCode() === self::SUCCESS_NO_CONTENT) {
            return null;
        }

        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new UserGrant($this->client, $json);
    }

    /**
     * {@inheritdoc}
     */
    public function setUserGrants(string $username, array $parameters): UserGrant
    {
        $response = $this->client->api($this->client::REQUEST_PUT, sprintf('%s/%s/grants', $this->getBaseUri(), $username), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new UserGrant($this->client, $json);
    }

    /**
     * {@inheritdoc}
     */
    protected function getBaseUri(): string
    {
        return '/account/users';
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedFields(): array
    {
        return [
            User::FIELD_USERNAME,
            User::FIELD_EMAIL,
            User::FIELD_RESTRICTED,
            User::FIELD_SSH_KEYS,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function jsonToEntity(array $json): Entity
    {
        return new User($this->client, $json);
    }
}
