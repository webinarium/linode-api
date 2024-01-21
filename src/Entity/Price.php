<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity;

/**
 * Cost in US dollars, broken down into hourly and monthly charges.
 *
 * @property float $hourly  Cost (in US dollars) per hour.
 * @property float $monthly Cost (in US dollars) per month.
 */
class Price extends Entity
{
}
