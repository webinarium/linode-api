<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity;

/**
 * Detailed information about the entity, including ID, type, label, and URL used to access it.
 *
 * @property int    $id    The unique ID for this Entity.
 * @property string $type  The type of entity this is related to (@see `TYPE_...` constants).
 * @property string $label The current label of this object.
 * @property string $url   The URL where you can access the object this entity is for. If
 *                         a relative URL, it is relative to the domain you retrieved the
 *                         object from.
 */
class LinodeEntity extends Entity
{
    // Entity types.
    public const TYPE_ACCOUNT         = 'account';
    public const TYPE_BACKUPS         = 'backups';
    public const TYPE_COMMUNITY       = 'community';
    public const TYPE_DISKS           = 'disks';
    public const TYPE_DOMAIN          = 'domain';
    public const TYPE_IMAGE           = 'image';
    public const TYPE_IPADDRESS       = 'ipaddress';
    public const TYPE_LINODE          = 'linode';
    public const TYPE_LONGVIEW        = 'longview';
    public const TYPE_MANAGED_SERVICE = 'managed_service';
    public const TYPE_NODE_BALANCER   = 'nodebalancer';
    public const TYPE_OAUTH_CLIENT    = 'oauth_client';
    public const TYPE_PROFILE         = 'profile';
    public const TYPE_STACK_SCRIPT    = 'stackscript';
    public const TYPE_TAG             = 'tag';
    public const TYPE_TICKET          = 'ticket';
    public const TYPE_TOKEN           = 'token';
    public const TYPE_USER            = 'user';
    public const TYPE_USER_SSH_KEY    = 'user_ssh_key';
    public const TYPE_VOLUME          = 'volume';
}
