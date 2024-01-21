<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity\Profile;

use Linode\Entity\Entity;

/**
 * Profile information object.
 *
 * @property int              $uid                  Your unique ID in our system. This value will never change, and can
 *                                                  safely be used to identify your User.
 * @property string           $username             Your username, used for logging in to our system.
 * @property string           $email                Your email address. This address will be used for communication with Linode
 *                                                  as necessary.
 * @property bool             $restricted           If `true`, your User has restrictions on what can be accessed on your
 *                                                  Account.
 * @property bool             $two_factor_auth      If `true`, logins from untrusted computers will require Two Factor
 *                                                  Authentication.
 * @property bool             $email_notifications  If `true`, you will receive email notifications about account activity. If false,
 *                                                  you may still receive business-critical communications through email.
 * @property bool             $ip_whitelist_enabled If `true`, logins for your User will only be allowed from whitelisted IPs.
 *                                                  This setting is currently deprecated, and cannot be enabled.
 * @property string           $lish_auth_method     What methods of authentication are allowed when connecting via
 *                                                  Lish. "keys_only" is the most secure if you intend to use Lish,
 *                                                  and "disabled" is recommended if you do not intend to use Lish at
 *                                                  all (@see `LISH_AUTH_METHOD_...` constants).
 * @property string           $timezone             The timezone you prefer to see times in. This is not used by the API, and is
 *                                                  for the benefit of clients only. All times the API returns are in UTC.
 * @property null|string[]    $authorized_keys      The list of SSH Keys authorized to use Lish for your User. This value is ignored if
 *                                                  `lish_auth_method` is "disabled."
 * @property ProfileReferrals $referrals            Information about your status in our referral program.
 */
class ProfileInformation extends Entity
{
    // Available fields.
    public const FIELD_EMAIL                = 'email';
    public const FIELD_RESTRICTED           = 'restricted';
    public const FIELD_TWO_FACTOR_AUTH      = 'two_factor_auth';
    public const FIELD_EMAIL_NOTIFICATIONS  = 'email_notifications';
    public const FIELD_IP_WHITELIST_ENABLED = 'ip_whitelist_enabled';
    public const FIELD_LISH_AUTH_METHOD     = 'lish_auth_method';
    public const FIELD_TIMEZONE             = 'timezone';
    public const FIELD_AUTHORIZED_KEYS      = 'authorized_keys';

    // Lish authentication methods.
    public const LISH_AUTH_METHOD_PASSWORD_KEYS = 'password_keys';
    public const LISH_AUTH_METHOD_KEYS_ONLY     = 'keys_only';
    public const LISH_AUTH_METHOD_DISABLED      = 'disabled';

    /**
     * {@inheritdoc}
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'referrals' => new ProfileReferrals($this->client, $this->data['referrals']),
            default     => parent::__get($name),
        };
    }
}
