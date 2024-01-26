<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\StackScripts;

use Linode\Entity;

/**
 * A custom field defined by the User with a special syntax within a StackScript.
 * Derived from the contents of the script.
 *
 * @property string $label   A human-readable label for the field that will serve as the input prompt for
 *                           entering the value during deployment.
 * @property string $name    The name of the field.
 * @property string $example An example value for the field.
 * @property string $oneOf   A list of acceptable single values for the field.
 * @property string $manyOf  A list of acceptable values for the field in any quantity, combination or order.
 * @property string $default The default value. If not specified, this value will be used.
 */
class UserDefinedField extends Entity
{
    // Available fields.
    public const FIELD_LABEL   = 'label';
    public const FIELD_NAME    = 'name';
    public const FIELD_EXAMPLE = 'example';
    public const FIELD_ONEOF   = 'oneOf';
    public const FIELD_MANYOF  = 'manyOf';
    public const FIELD_DEFAULT = 'default';
}
