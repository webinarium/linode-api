<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\LinodeInstances;

use Linode\Entity;

/**
 * Linux kernel object.
 *
 * @property string $id           The unique ID of this Kernel.
 * @property string $label        The friendly name of this Kernel.
 * @property string $version      Linux Kernel version.
 * @property string $architecture The architecture of this Kernel.
 * @property bool   $kvm          If this Kernel is suitable for KVM Linodes.
 * @property bool   $pvops        If this Kernel is suitable for paravirtualized operations.
 * @property bool   $deprecated   If this Kernel is marked as deprecated, this field has a value of true; otherwise,
 *                                this field is false.
 * @property string $built        The date on which this Kernel was built.
 */
class Kernel extends Entity
{
    // Available fields.
    public const FIELD_ID           = 'id';
    public const FIELD_LABEL        = 'label';
    public const FIELD_VERSION      = 'version';
    public const FIELD_ARCHITECTURE = 'architecture';
    public const FIELD_KVM          = 'kvm';
    public const FIELD_PVOPS        = 'pvops';
    public const FIELD_DEPRECATED   = 'deprecated';
    public const FIELD_BUILT        = 'built';

    // `FIELD_ARCHITECTURE` values.
    public const ARCHITECTURE_X86_64 = 'x86_64';
    public const ARCHITECTURE_I386   = 'i386';
}
