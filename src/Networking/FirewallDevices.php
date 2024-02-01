<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Networking;

use Linode\Entity;
use Linode\Linode\LinodeEntity;

/**
 * Associates a Firewall with a Linode service. A Firewall can be assigned to a
 * single Linode service at a time. Additional disabled Firewalls can be assigned to
 * a service, but they cannot be enabled if another active Firewall is already
 * assigned to the same service.
 *
 * @property int          $id      The Device's unique ID
 * @property string       $created When this Device was created.
 * @property string       $updated When this Device was last updated.
 * @property LinodeEntity $entity  The Linode service that this Firewall has been applied to.
 */
class FirewallDevices extends Entity
{
    // Available fields.
    public const FIELD_ID      = 'id';
    public const FIELD_CREATED = 'created';
    public const FIELD_UPDATED = 'updated';
    public const FIELD_ENTITY  = 'entity';
}
