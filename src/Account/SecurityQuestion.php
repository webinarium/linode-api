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
 * Single security question and response object.
 *
 * @property int    $id       The ID representing the security question.
 * @property string $question The security question.
 * @property string $response The security question response.
 */
class SecurityQuestion extends Entity
{
    // Available fields.
    public const FIELD_ID       = 'id';
    public const FIELD_QUESTION = 'question';
    public const FIELD_RESPONSE = 'response';
}
