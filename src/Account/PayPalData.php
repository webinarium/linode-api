<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Account;

use Linode\Entity;

/**
 * PayPal information.
 *
 * @property string $email     The email address associated with your PayPal account.
 * @property string $paypal_id PayPal Merchant ID associated with your PayPal account.
 */
class PayPalData extends Entity
{
    // Available fields.
    public const FIELD_EMAIL     = 'email';
    public const FIELD_PAYPAL_ID = 'paypal_id';
}
