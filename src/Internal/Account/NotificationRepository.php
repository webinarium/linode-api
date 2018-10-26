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

use Linode\Entity\Account\Notification;
use Linode\Entity\Entity;
use Linode\Internal\AbstractRepository;
use Linode\Repository\Account\NotificationRepositoryInterface;

/**
 * {@inheritdoc}
 */
class NotificationRepository extends AbstractRepository implements NotificationRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    protected function getBaseUri(): string
    {
        return '/account/notifications';
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
    protected function jsonToEntity(array $json): Entity
    {
        return new Notification($this->client, $json);
    }
}
