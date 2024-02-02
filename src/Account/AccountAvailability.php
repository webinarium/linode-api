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
 * Account Service Availability object.
 *
 * @property string   $region      Displays the data center represented by a slug.
 * @property string[] $unavailable A list of strings of unavailable services.
 */
class AccountAvailability extends Entity
{
    // Available fields.
    public const FIELD_REGION      = 'region';
    public const FIELD_UNAVAILABLE = 'unavailable';
}
