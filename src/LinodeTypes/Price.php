<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\LinodeTypes;

use Linode\Entity;

/**
 * Cost in US dollars, broken down into hourly and monthly charges.
 *
 * @property float $hourly  Cost (in US dollars) per hour.
 * @property float $monthly Cost (in US dollars) per month.
 */
class Price extends Entity {}
