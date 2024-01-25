<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Profile;

use Linode\Entity;

/**
 * Information about profile status in the referral program.
 *
 * @property string $code      Your referral code. If others use this when signing up for Linode, you will
 *                             receive account credit.
 * @property string $url       Your referral url, used to direct others to sign up for Linode with your referral
 *                             code.
 * @property int    $total     The number of users who have signed up with your referral code.
 * @property int    $completed The number of completed signups with your referral code.
 * @property int    $pending   The number of pending signups with your referral code. You will not receive
 *                             credit for these signups until they are completed.
 * @property int    $credit    The amount of account credit in US Dollars issued to you through
 *                             the referral program.
 */
class ProfileReferrals extends Entity {}
