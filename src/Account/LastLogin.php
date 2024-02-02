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
 * Information for the most recent login attempt for this User.
 *
 * @property string $datetime The date and time of this User's most recent login attempt.
 * @property string $status   The result of the most recent login attempt for this User.
 */
class LastLogin extends Entity {}
