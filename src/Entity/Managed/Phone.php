<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity\Managed;

use Linode\Entity\Entity;

/**
 * Information about how to reach a Contact by phone.
 *
 * @property null|string $primary   A contact's primary phone number.
 * @property null|string $secondary A contact's secondary phone number.
 */
class Phone extends Entity
{
    // Available fields.
    public const FIELD_PRIMARY   = 'primary';
    public const FIELD_SECONDARY = 'secondary';
}
