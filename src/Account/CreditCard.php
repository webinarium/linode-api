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
 * Credit card information.
 *
 * @property string $card_type The type of credit card.
 * @property string $last_four The last four digits of the credit card number.
 * @property string $expiry    The expiration month and year of the credit card.
 */
class CreditCard extends Entity
{
    // Available fields.
    public const FIELD_CARD_TYPE = 'card_type';
    public const FIELD_LAST_FOUR = 'last_four';
    public const FIELD_EXPIRY    = 'expiry';
}
