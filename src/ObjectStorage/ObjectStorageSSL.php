<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\ObjectStorage;

use Linode\Entity;

/**
 * Upload a TLS/SSL certificate and private key to be served when you visit your
 * Object Storage bucket via HTTPS.
 *
 * @property string $certificate Your Base64 encoded and PEM formatted SSL certificate.
 *                               Line breaks must be represented as "\n" in the string for requests (but not when
 *                               using the Linode CLI)
 * @property string $private_key The private key associated with this TLS/SSL certificate.
 *                               Line breaks must be represented as "\n" in the string for requests (but not when
 *                               using the Linode CLI)
 */
class ObjectStorageSSL extends Entity
{
    // Available fields.
    public const FIELD_CERTIFICATE = 'certificate';
    public const FIELD_PRIVATE_KEY = 'private_key';
}
