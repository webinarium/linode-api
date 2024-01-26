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
 * A third-party application registered to Linode that users may log into with their
 * Linode account through our authentication server at https://login.linode.com.
 * Using an OAuth Client, a third-party developer may be given access to some, or
 * all, of a User's account for the purposes of their application.
 *
 * @property string      $id            The OAuth Client ID. This is used to identify the client, and is a publicly-known
 *                                      value (it is not a secret).
 * @property string      $label         The name of this application. This will be presented to users when they are asked
 *                                      to grant it access to their Account.
 * @property string      $status        The status of this application. `active` by default.
 * @property bool        $public        If this is a public or private OAuth Client. Public clients have a slightly
 *                                      different authentication workflow than private clients. See the OAuth spec for
 *                                      more details.
 * @property string      $redirect_uri  The location a successful log in from https://login.linode.com should be
 *                                      redirected to for this client. The receiver of this redirect should be ready to
 *                                      accept an OAuth exchange code and finish the OAuth exchange.
 * @property string      $secret        The OAuth Client secret, used in the OAuth exchange. This is returned as
 *                                      `<REDACTED>` except when an OAuth Client is created or its secret is reset. This
 *                                      is a secret, and should not be shared or disclosed publicly.
 * @property null|string $thumbnail_url The URL where this client's thumbnail may be viewed, or `null` if this client does
 *                                      not have a thumbnail set.
 */
class OAuthClient extends Entity
{
    // Available fields.
    public const FIELD_ID            = 'id';
    public const FIELD_LABEL         = 'label';
    public const FIELD_STATUS        = 'status';
    public const FIELD_PUBLIC        = 'public';
    public const FIELD_REDIRECT_URI  = 'redirect_uri';
    public const FIELD_SECRET        = 'secret';
    public const FIELD_THUMBNAIL_URL = 'thumbnail_url';

    // `FIELD_STATUS` values.
    public const STATUS_ACTIVE    = 'active';
    public const STATUS_DISABLED  = 'disabled';
    public const STATUS_SUSPENDED = 'suspended';
}
