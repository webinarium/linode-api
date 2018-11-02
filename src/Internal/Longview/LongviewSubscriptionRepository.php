<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal\Longview;

use Linode\Entity\Entity;
use Linode\Entity\Longview\LongviewSubscription;
use Linode\Internal\AbstractRepository;
use Linode\Repository\Longview\LongviewSubscriptionRepositoryInterface;

/**
 * {@inheritdoc}
 */
class LongviewSubscriptionRepository extends AbstractRepository implements LongviewSubscriptionRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    protected function getBaseUri(): string
    {
        return '/longview/subscriptions';
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedFields(): array
    {
        return [
            LongviewSubscription::FIELD_ID,
            LongviewSubscription::FIELD_LABEL,
            LongviewSubscription::FIELD_CLIENTS_INCLUDED,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function jsonToEntity(array $json): Entity
    {
        return new LongviewSubscription($this->client, $json);
    }
}
