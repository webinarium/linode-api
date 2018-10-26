<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity\Account;

use Linode\Entity\Entity;

/**
 * A structure representing all grants a restricted User has on the
 * Account. Not available for unrestricted users, as they have access to
 * everything without grants. If retrieved from the `/profile/grants`
 * endpoint, entities to which a User has no access will be omitted.
 *
 * @property GlobalGrant   $global       A structure containing the Account-level grants a User has.
 * @property array|Grant[] $linode       The grants this User has pertaining to Linodes on this Account.
 * @property array|Grant[] $domain       The grants this User has pertaining to Domains on this Account.
 * @property array|Grant[] $nodebalancer The grants this User has pertaining to NodeBalancers on this Account.
 * @property array|Grant[] $image        The grants this User has pertaining to Images on this Account.
 * @property array|Grant[] $longview     The grants this User has pertaining to Longview Clients on this Account.
 * @property array|Grant[] $stackscript  The grants this User has pertaining to StackScripts on this Account.
 * @property array|Grant[] $volume       The grants this User has pertaining to Volumes on this Account.
 */
class UserGrant extends Entity
{
    // Available fields.
    public const FIELD_GLOBAL       = 'global';
    public const FIELD_LINODE       = 'linode';
    public const FIELD_DOMAIN       = 'domain';
    public const FIELD_NODEBALANCER = 'nodebalancer';
    public const FIELD_IMAGE        = 'image';
    public const FIELD_LONGVIEW     = 'longview';
    public const FIELD_STACKSCRIPT  = 'stackscript';
    public const FIELD_VOLUME       = 'volume';

    /**
     * {@inheritdoc}
     */
    public function __get(string $name)
    {
        if ($name === self::FIELD_GLOBAL) {
            return new GlobalGrant($this->client, $this->data[self::FIELD_GLOBAL]);
        }

        if (array_key_exists($name, $this->data)) {
            return array_map(function ($data) {
                return new Grant($this->client, $data);
            }, $this->data[$name]);
        }

        return null;
    }
}
