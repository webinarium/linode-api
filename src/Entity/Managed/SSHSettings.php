<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity\Managed;

use Linode\Entity\Entity;

/**
 * A Linode SSH settings.
 *
 * @property bool   $access If true, Linode special forces may access this Linode over
 *                          ssh to respond to Issues.
 * @property string $user   The user Linode's special forces should use when accessing this
 *                          Linode to respond to an issue.
 * @property string $ip     The IP Linode special forces should use to access this Linode
 *                          when responding to an Issue.
 * @property int    $port   The port Linode special forces should use to access this Linode
 *                          over ssh to respond to an Issue.
 */
class SSHSettings extends Entity
{
    // Available fields.
    public const FIELD_ACCESS = 'access';
    public const FIELD_USER   = 'user';
    public const FIELD_IP     = 'ip';
    public const FIELD_PORT   = 'port';
}
