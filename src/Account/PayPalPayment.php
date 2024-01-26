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
 * PayPal Payment staged.
 *
 * @property string $payment_id     The paypal-generated ID for this Payment. Used when
 *                                  authorizing the Payment in PayPal's interface.
 * @property string $checkout_token The checkout token generated for this Payment.
 */
class PayPalPayment extends Entity
{
    // Available fields.
    public const FIELD_PAYMENT_ID     = 'payment_id';
    public const FIELD_CHECKOUT_TOKEN = 'checkout_token';
}
