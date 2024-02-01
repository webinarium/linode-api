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

/**
 * A virtual local area network (VLAN) associated with your Account.
 *
 * @property string $region  This VLAN's data center region.
 *                           **Note:** Currently, a VLAN can only be assigned to a Linode
 *                           within the same data center region.
 * @property string $label   The name of this VLAN.
 * @property int[]  $linodes An array of Linode IDs attached to this VLAN.
 * @property string $created The date this VLAN was created.
 */
class Vlans extends Entity
{
    // Available fields.
    public const FIELD_REGION  = 'region';
    public const FIELD_LABEL   = 'label';
    public const FIELD_LINODES = 'linodes';
    public const FIELD_CREATED = 'created';
}
