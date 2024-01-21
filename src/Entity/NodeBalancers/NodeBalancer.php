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
use Linode\Internal\NodeBalancers\NodeBalancerConfigRepository;
use Linode\Repository\NodeBalancers\NodeBalancerConfigRepositoryInterface;

/**
 * Linode's load balancing solution. Can handle multiple ports, SSL termination,
 * and any number of backends. NodeBalancer ports are configured with
 * NodeBalancer Configs, and each config is given one or more NodeBalancer Node that
 * accepts traffic. The traffic should be routed to the NodeBalancer's ip address,
 * the NodeBalancer will handle routing individual requests to backends.
 *
 * @property int                                   $id                   This NodeBalancer's unique ID.
 * @property string                                $label                This NodeBalancer's label. These must be unique on your Account.
 * @property string                                $region               The Region where this NodeBalancer is located. NodeBalancers only
 *                                                                       support backends in the same Region.
 * @property string                                $hostname             This NodeBalancer's hostname, ending with ".nodebalancer.linode.com".
 * @property string                                $ipv4                 This NodeBalancer's public IPv4 address.
 * @property string                                $ipv6                 This NodeBalancer's public IPv6 address.
 * @property int                                   $client_conn_throttle Throttle connections per second. Set to 0 (zero) to disable throttling.
 * @property string                                $created              When this NodeBalancer was created.
 * @property string                                $updated              When this NodeBalancer was last updated.
 * @property NodeTransfer                          $transfer             Information about the amount of transfer this NodeBalancer has had
 *                                                                       so far this month.
 * @property NodeBalancerConfigRepositoryInterface $configs              Configs of the NodeBalancer.
 */
class NodeBalancer extends Entity
{
    // Available fields.
    public const FIELD_ID                   = 'id';
    public const FIELD_LABEL                = 'label';
    public const FIELD_REGION               = 'region';
    public const FIELD_HOSTNAME             = 'hostname';
    public const FIELD_IPV4                 = 'ipv4';
    public const FIELD_IPV6                 = 'ipv6';
    public const FIELD_CLIENT_CONN_THROTTLE = 'client_conn_throttle';

    // Extra field for create/update operations.
    public const FIELD_CONFIGS = 'configs';

    public function __get(string $name): mixed
    {
        return match ($name) {
            'transfer' => new NodeTransfer($this->client, $this->data[$name]),
            'configs'  => new NodeBalancerConfigRepository($this->client, $this->id),
            default    => parent::__get($name),
        };
    }
}
