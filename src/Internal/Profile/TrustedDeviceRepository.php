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
use Linode\Entity\Profile\TrustedDevice;
use Linode\Internal\AbstractRepository;
use Linode\Repository\Profile\TrustedDeviceRepositoryInterface;

class TrustedDeviceRepository extends AbstractRepository implements TrustedDeviceRepositoryInterface
{
    public function revoke(int $id): void
    {
        $this->client->api($this->client::REQUEST_DELETE, sprintf('%s/%s', $this->getBaseUri(), $id));
    }

    protected function getBaseUri(): string
    {
        return '/profile/devices';
    }

    protected function getSupportedFields(): array
    {
        return [
            TrustedDevice::FIELD_ID,
            TrustedDevice::FIELD_CREATED,
            TrustedDevice::FIELD_EXPIRY,
            TrustedDevice::FIELD_USER_AGENT,
            TrustedDevice::FIELD_LAST_AUTHENTICATED,
            TrustedDevice::FIELD_LAST_REMOTE_ADDR,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new TrustedDevice($this->client, $json);
    }
}
