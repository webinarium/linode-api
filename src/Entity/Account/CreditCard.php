<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity\Account;

use Linode\Entity\Entity;

/**
 * Credit Card information.
 *
 * @property string $last_four The last four digits of the credit card.
 * @property string $expiry    The expiration month and year of the credit card.
 */
class CreditCard extends Entity {}
