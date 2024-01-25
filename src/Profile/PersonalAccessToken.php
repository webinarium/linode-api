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
 * A Personal Access Token is a token generated manually to access the API
 * without going through an OAuth login. Personal Access Tokens can have
 * scopes just like OAuth tokens do, and are commonly used to give access
 * to command-line tools like the Linode CLI, or when writing your own
 * integrations.
 *
 * @property int    $id      This token's unique ID, which can be used to revoke it.
 * @property string $label   This token's label. This is for display purposes only, but can be used to
 *                           more easily track what you're using each token for.
 * @property string $scopes  The scopes this token was created with. These define what parts of
 *                           the Account the token can be used to access. Many command-line tools,
 *                           such as the Linode CLI (@see https://github.com/linode/linode-cli),
 *                           require tokens with access to `*`. Tokens with more restrictive scopes
 *                           are generally more secure.
 * @property string $created The date and time this token was created.
 * @property string $token   The token used to access the API. When the token is created, the full token
 *                           is returned here. Otherwise, only the first 16 characters are returned.
 * @property string $expiry  When this token will expire. Personal Access Tokens cannot be renewed, so
 *                           after this time the token will be completely unusable and a new token will
 *                           need to be generated. Tokens may be created with "null" as their expiry
 *                           and will never expire unless revoked.
 */
class PersonalAccessToken extends Entity
{
    // Available fields.
    public const FIELD_ID      = 'id';
    public const FIELD_LABEL   = 'label';
    public const FIELD_SCOPES  = 'scopes';
    public const FIELD_CREATED = 'created';
    public const FIELD_TOKEN   = 'token';
    public const FIELD_EXPIRY  = 'expiry';
}
