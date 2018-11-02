<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity\Managed;

use Linode\Entity\Entity;

/**
 * A securely-stored Credential that allows Linode's special forces
 * to access a Managed server to respond to Issues.
 *
 * @property int    $id    This Credential's unique ID.
 * @property string $label The unique label for this Credential. This is for display purposes only.
 */
class ManagedCredential extends Entity
{
    // Available fields.
    public const FIELD_ID    = 'id';
    public const FIELD_LABEL = 'label';

    // Extra field for create/update operations.
    public const FIELD_USERNAME = 'username';
    public const FIELD_PASSWORD = 'password';
}
