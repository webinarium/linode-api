<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\LKE;

use Linode\Entity;

/**
 * Status information for a Node which is a member of a Kubernetes cluster.
 *
 * @property int    $id          The Node's ID.
 * @property string $instance_id The Linode's ID. When no Linode is currently provisioned for this Node, this will
 *                               be null.
 * @property string $status      The Node's status as it pertains to being a Kubernetes node.
 */
class LKENodeStatus extends Entity
{
    // Available fields.
    public const FIELD_ID          = 'id';
    public const FIELD_INSTANCE_ID = 'instance_id';
    public const FIELD_STATUS      = 'status';

    // `FIELD_STATUS` values.
    public const STATUS_READY     = 'ready';
    public const STATUS_NOT_READY = 'not_ready';
}
