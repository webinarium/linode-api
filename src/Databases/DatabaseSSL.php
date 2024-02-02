<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Databases;

use Linode\Entity;

/**
 * Managed Database SSL object.
 *
 * @property string $ca_certificate The base64-encoded SSL CA certificate for the Managed Database instance.
 */
class DatabaseSSL extends Entity
{
    // Available fields.
    public const FIELD_CA_CERTIFICATE = 'ca_certificate';
}
