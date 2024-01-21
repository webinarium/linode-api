<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity\NodeBalancers;

use Linode\Entity\Entity;

/**
 * A NodeBalancerNode represents a single backend serving requests for a single
 * port of a NodeBalancer. Nodes are specific to NodeBalancer Configs, and serve
 * traffic over their private IP. If the same Linode is serving traffic for more
 * than one port on the same NodeBalancer, one NodeBalancer Node is required for
 * each config (port) it should serve requests on. For example, if you have
 * four backends, and each should response to both HTTP and HTTPS requests, you
 * will need two NodeBalancerConfigs (port 80 and port 443) and four backends
 * each - one for each of the Linodes serving requests for that port.
 *
 * @property int    $id              This node's unique ID.
 * @property string $label           The label for this node. This is for display purposes only.
 * @property string $address         The private IP Address where this backend can be reached. This _must_
 *                                   be a private IP address.
 * @property string $status          The current status of this node, based on the configured checks
 *                                   of its NodeBalancer Config.
 * @property int    $weight          Used when picking a backend to serve a request and is not pinned to
 *                                   a single backend yet. Nodes with a higher weight will receive more
 *                                   traffic.
 * @property string $mode            The mode this NodeBalancer should use when sending traffic to this backend.
 * @property int    $nodebalancer_id The NodeBalancer ID that this Node belongs to.
 * @property int    $config_id       The NodeBalancer Config ID that this Node belongs to.
 */
class NodeBalancerNode extends Entity
{
    // Available fields.
    public const FIELD_ID      = 'id';
    public const FIELD_LABEL   = 'label';
    public const FIELD_ADDRESS = 'address';
    public const FIELD_STATUS  = 'status';
    public const FIELD_WEIGHT  = 'weight';
    public const FIELD_MODE    = 'mode';

    // Node statuses.
    public const STATUS_UNKNOWN = 'unknown';
    public const STATUS_UP      = 'UP';
    public const STATUS_DOWN    = 'DOWN';

    // Traffic modes.
    public const MODE_ACCEPT = 'accept';
    public const MODE_REJECT = 'reject';
    public const MODE_DRAIN  = 'drain';
    public const MODE_BACKUP = 'backup';
}
