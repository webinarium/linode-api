<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity\Linode;

use Linode\Entity\Entity;

/**
 * Information about the resources available to this Linode.
 *
 * @property int $disk     The amount of storage space, in GB. this Linode has access to. A typical Linode
 *                         will divide this space between a primary disk with an `image` deployed to it, and
 *                         a swap disk, usually 512 MB. This is the default configuration created when
 *                         deploying a Linode with an `image` through `POST /linode/instances`.
 *                         While this configuration is suitable for 99% of use cases, if you need finer control over
 *                         your Linode's disks, see the `/linode/instances/{linodeId}/disks` endpoints.
 * @property int $memory   The amount of RAM, in MB, this Linode has access to. Typically a Linode will
 *                         choose to boot with all of its available RAM, but this can be configured in a
 *                         Config profile, see the `/linode/instances/{linodeId}/configs` endpoints and
 *                         the LinodeConfig object for more information.
 * @property int $vcpus    The number of vcpus this Linode has access to.  Typically a Linode will choose to
 *                         boot with all of its available vcpus, but this can be configured in a Config Profile,
 *                         see the `/linode/instances/{linodeId}/configs` endpoints and the LinodeConfig object
 *                         for more information.
 * @property int $transfer The amount of network transfer this Linode is allotted each month.
 */
class LinodeSpecs extends Entity
{
}
