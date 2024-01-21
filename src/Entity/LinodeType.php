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
 * Linode type, including pricing and specifications.
 * These are used when creating or resizing Linodes.
 *
 * @property string      $id          The ID representing the Linode Type.
 * @property string      $label       The Linode Type's label is for display purposes only.
 * @property string      $class       The class of the Linode Type (@see `CLASS_...` constants).
 * @property int         $disk        The Disk size, in MB, of the Linode Type.
 * @property int         $memory      Amount of RAM included in this Linode Type.
 * @property int         $vcpus       The number of VCPU cores this Linode Type offers.
 * @property int         $network_out The Mbits outbound bandwidth allocation.
 * @property int         $transfer    The monthly outbound transfer amount, in MB.
 * @property Price       $price       Cost in US dollars, broken down into hourly and monthly charges.
 * @property array       $addons      A list of optional add-on services for Linodes and their associated costs.
 * @property null|string $successor   The Linode Type that a `mutate` operation will upgrade to for a Linode of this type.
 *                                    If "null", a Linode of this type may not mutate.
 */
class LinodeType extends Entity
{
    // Available fields.
    public const FIELD_ID          = 'id';
    public const FIELD_LABEL       = 'label';
    public const FIELD_CLASS       = 'class';
    public const FIELD_DISK        = 'disk';
    public const FIELD_MEMORY      = 'memory';
    public const FIELD_VCPLUS      = 'vcpus';
    public const FIELD_NETWORK_OUT = 'network_out';
    public const FIELD_TRANSFER    = 'transfer';

    // Linode type classes.
    public const CLASS_NANODE   = 'nanode';
    public const CLASS_STANDARD = 'standard';
    public const CLASS_HIGHMEM  = 'highmem';

    /**
     * {@inheritdoc}
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'price' => new Price($this->client, $this->data[$name] ?? []),
            default => parent::__get($name),
        };
    }
}
