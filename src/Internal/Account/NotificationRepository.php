<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal\Account;

use Linode\Entity\Account\Notification;
use Linode\Entity\Entity;
use Linode\Internal\AbstractRepository;
use Linode\Repository\Account\NotificationRepositoryInterface;

class NotificationRepository extends AbstractRepository implements NotificationRepositoryInterface
{
    protected function getBaseUri(): string
    {
        return '/account/notifications';
    }

    protected function getSupportedFields(): array
    {
        return [
            Notification::FIELD_LABEL,
            Notification::FIELD_MESSAGE,
            Notification::FIELD_SEVERITY,
            Notification::FIELD_WHEN,
            Notification::FIELD_UNTIL,
            Notification::FIELD_TYPE,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new Notification($this->client, $json);
    }
}
