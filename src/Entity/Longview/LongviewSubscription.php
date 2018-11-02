<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity\Longview;

use Linode\Entity\Entity;
use Linode\Entity\Price;

/**
 * A Longview Subscriptions represents a tier of Longview service you can subscribe to.
 *
 * @property string $id               The unique ID of this Subscription tier.
 * @property string $label            A display name for this Subscription tier.
 * @property int    $clients_included The number of Longview Clients that may be created with this Subscription tier.
 * @property Price  $price            Pricing information about this Subscription tier.
 */
class LongviewSubscription extends Entity
{
    // Available fields.
    public const FIELD_ID               = 'id';
    public const FIELD_LABEL            = 'label';
    public const FIELD_CLIENTS_INCLUDED = 'clients_included';

    /**
     * {@inheritdoc}
     */
    public function __get(string $name)
    {
        if ($name === 'price') {
            return new Price($this->client, $this->data['price']);
        }

        return parent::__get($name);
    }
}
