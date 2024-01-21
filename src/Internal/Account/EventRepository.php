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

use Linode\Entity\Account\Event;
use Linode\Entity\Entity;
use Linode\Internal\AbstractRepository;
use Linode\Repository\Account\EventRepositoryInterface;

/**
 * {@inheritdoc}
 */
class EventRepository extends AbstractRepository implements EventRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function markAsSeen(int $id): void
    {
        $this->client->api($this->client::REQUEST_POST, sprintf('%s/%s/seen', $this->getBaseUri(), $id));
    }

    /**
     * {@inheritdoc}
     */
    public function markAsRead(int $id): void
    {
        $this->client->api($this->client::REQUEST_POST, sprintf('%s/%s/read', $this->getBaseUri(), $id));
    }

    /**
     * {@inheritdoc}
     */
    protected function getBaseUri(): string
    {
        return '/account/events';
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedFields(): array
    {
        return [
            Event::FIELD_ID,
            Event::FIELD_USERNAME,
            Event::FIELD_ACTION,
            Event::FIELD_CREATED,
            Event::FIELD_STATUS,
            Event::FIELD_SEEN,
            Event::FIELD_READ,
            Event::FIELD_RATE,
            Event::FIELD_PERCENT_COMPLETE,
            Event::FIELD_TIME_REMAINING,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function jsonToEntity(array $json): Entity
    {
        return new Event($this->client, $json);
    }
}
