<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity\Profile;

use Linode\Entity\Entity;

/**
 * Two Factor secret generated.
 *
 * @property string $secret Your Two Factor secret. This is used to generate
 *                          time-based two factor codes required for logging in. Doing
 *                          this will be required to confirm TFA an actually enable it.
 * @property string $expiry When this Two Factor secret expires.
 */
class TwoFactorSecret extends Entity
{
}
