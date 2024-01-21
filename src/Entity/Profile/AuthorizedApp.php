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
 * An application you have authorized access to your Account through OAuth.
 *
 * @property int    $id            This authorization's ID, used for revoking access.
 * @property string $label         The name of the application you've authorized.
 * @property string $scopes        The OAuth scopes this app was authorized with. This defines what parts of your
 *                                 Account the app is allowed to access.
 * @property string $website       The website where you can get more information about this app.
 * @property string $created       When this app was authorized.
 * @property string $expiry        When this app's access token expires. Please note that apps may still have active
 *                                 refresh tokens after this time passes.
 * @property string $thumbnail_url The URL at which this app's thumbnail may be accessed.
 */
class AuthorizedApp extends Entity
{
    // Available fields.
    public const FIELD_ID            = 'id';
    public const FIELD_LABEL         = 'label';
    public const FIELD_SCOPES        = 'scopes';
    public const FIELD_WEBSITE       = 'website';
    public const FIELD_CREATED       = 'created';
    public const FIELD_EXPIRY        = 'expiry';
    public const FIELD_THUMBNAIL_URL = 'thumbnail_url';
}
