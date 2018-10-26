<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity\Account;

use Linode\Entity\Entity;

/**
 * Payment object.
 *
 * @property int    $id   The unique ID of the Payment.
 * @property string $date When the Payment was made.
 * @property float  $usd  The amount, in US dollars, of the Payment.
 */
class Payment extends Entity
{
    // Available fields.
    public const FIELD_ID   = 'id';
    public const FIELD_DATE = 'date';
    public const FIELD_USD  = 'usd';
}
