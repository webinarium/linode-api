<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal\Profile;

use Linode\Entity\Entity;
use Linode\Entity\Profile\AuthorizedApp;
use Linode\Internal\AbstractRepository;
use Linode\Repository\Profile\AuthorizedAppRepositoryInterface;

class AuthorizedAppRepository extends AbstractRepository implements AuthorizedAppRepositoryInterface
{
    public function revoke(int $id): void
    {
        $this->client->api($this->client::REQUEST_DELETE, sprintf('%s/%s', $this->getBaseUri(), $id));
    }

    protected function getBaseUri(): string
    {
        return '/profile/apps';
    }

    protected function getSupportedFields(): array
    {
        return [
            AuthorizedApp::FIELD_ID,
            AuthorizedApp::FIELD_LABEL,
            AuthorizedApp::FIELD_SCOPES,
            AuthorizedApp::FIELD_WEBSITE,
            AuthorizedApp::FIELD_CREATED,
            AuthorizedApp::FIELD_EXPIRY,
            AuthorizedApp::FIELD_THUMBNAIL_URL,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new AuthorizedApp($this->client, $json);
    }
}
