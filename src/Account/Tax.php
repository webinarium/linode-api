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
 * Tax information.
 *
 * @property float  $tax  The amount of tax subtotal attributable to this source.
 * @property string $name The source of this tax subtotal.
 */
class Tax extends Entity {}
