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
 * The set of Node Pools which are members of the Kubernetes cluster. Node Pools
 * consist of a Linode type, the number of Linodes to deploy of that type, and
 * additional status information.
 *
 * @property int             $id    This Node Pool's unique ID.
 * @property LKENodeStatus[] $nodes Status information for the Nodes which are members of this Node Pool. If a Linode
 *                                  has not been provisioned for a given Node slot, the instance_id will be returned
 *                                  as null.
 * @property string          $type  A Linode Type for all of the nodes in the Node Pool.
 * @property int             $count The number of nodes in the Node Pool.
 */
class LKENodePool extends Entity
{
    // Available fields.
    public const FIELD_ID    = 'id';
    public const FIELD_NODES = 'nodes';

    // Extra fields for POST/PUT requests.
    public const FIELD_TYPE  = 'type';
    public const FIELD_COUNT = 'count';
}
