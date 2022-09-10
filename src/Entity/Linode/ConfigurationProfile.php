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
 * Configuration profile associated with a Linode.
 *
 * @property int     $id           The ID of this Config.
 * @property string  $label        The Config's label is for display purposes only.
 * @property string  $kernel       A Kernel ID to boot a Linode with.
 * @property string  $comments     Optional field for arbitrary User comments on this Config.
 * @property int     $memory_limit Defaults to the total RAM of the Linode.
 * @property string  $run_level    Defines the state of your Linode after booting (@see `RUN_LEVEL_...` constants).
 * @property string  $virt_mode    Controls the virtualization mode. Defaults to `paravirt` (@see `VIRT_MODE_...` constants).
 * @property Helpers $helpers      Helpers enabled when booting to this Linode Config.
 * @property Devices $devices      Devices configuration.
 * @property string  $root_device  The root device to boot. The corresponding disk must be attached.
 */
class ConfigurationProfile extends Entity
{
    // Available fields.
    public const FIELD_ID           = 'id';
    public const FIELD_LABEL        = 'label';
    public const FIELD_KERNEL       = 'kernel';
    public const FIELD_COMMENTS     = 'comments';
    public const FIELD_MEMORY_LIMIT = 'memory_limit';
    public const FIELD_RUN_LEVEL    = 'run_level';
    public const FIELD_VIRT_MODE    = 'virt_mode';
    public const FIELD_HELPERS      = 'helpers';
    public const FIELD_DEVICES      = 'devices';
    public const FIELD_ROOT_DEVICE  = 'root_device';

    // Run levels.
    public const RUN_LEVEL_DEFAULT = 'default';
    public const RUN_LEVEL_SINGLE  = 'single';
    public const RUN_LEVEL_BINBASH = 'binbash';

    // Virtualization modes.
    public const VIRT_MODE_PARAVIRT = 'paravirt';
    public const VIRT_MODE_FULLVIRT = 'fullvirt';

    /**
     * {@inheritdoc}
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'helpers' => new Helpers($this->client, $this->data['helpers']),
            'devices' => new Devices($this->client, $this->data['devices']),
            default   => parent::__get($name),
        };
    }
}
