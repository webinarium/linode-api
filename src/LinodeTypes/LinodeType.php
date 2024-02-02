<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\LinodeTypes;

use Linode\Entity;
use Linode\Linode\Price;

/**
 * Returns collection of Linode types, including pricing and specifications for each
 * type. These are used when creating or resizing Linodes.
 *
 * @property string        $id            The ID representing the Linode Type.
 * @property string        $label         The Linode Type's label is for display purposes only.
 * @property string        $class         The class of the Linode Type.
 *                                        We currently offer six classes of compute instances:
 *                                        * `nanode` - Nanode instances are good for low-duty workloads, where performance
 *                                        isn't critical. **Note:** As of June 16th, 2020, Nanodes became 1 GB Linodes in
 *                                        the Cloud Manager, however, the API, the CLI, and billing will continue to refer
 *                                        to these instances as Nanodes.
 *                                        * `standard` - Standard Shared instances are good for medium-duty workloads and
 *                                        are a good mix of performance, resources, and price. **Note:** As of June 16th,
 *                                        2020, Standard Linodes in the Cloud Manager became Shared Linodes, however, the
 *                                        API, the CLI, and billing will continue to refer to these instances as Standard
 *                                        Linodes.
 *                                        * `dedicated` - Dedicated CPU instances are good for full-duty workloads where
 *                                        consistent performance is important.
 *                                        * `premium` (limited Regions) - In addition to the features of Dedicated
 *                                        instances, Premium instances come equipped with the latest AMD EPYC&trade; CPUs,
 *                                        ensuring your applications are running on the latest hardware with consistently
 *                                        high performance. Only available in Regions with "Premium Plans" in their
 *                                        `capabilities`
 *                                        * `gpu` (limited Regions) - Linodes with dedicated NVIDIA Quadro(R) RTX 6000
 *                                        GPUs accelerate highly specialized applications such as machine learning, AI, and
 *                                        video transcoding. Only available in Regions with "GPU Linodes" in their
 *                                        `capabilities`
 *                                        * `highmem` - High Memory instances favor RAM over other resources, and can be
 *                                        good for memory hungry use cases like caching and in-memory databases. All High
 *                                        Memory plans contain dedicated CPU cores.
 * @property int           $disk          The Disk size, in MB, of the Linode Type.
 * @property int           $memory        Amount of RAM included in this Linode Type.
 * @property int           $vcpus         The number of VCPU cores this Linode Type offers.
 * @property int           $gpus          The number of GPUs this Linode Type offers.
 * @property int           $network_out   The Mbits outbound bandwidth allocation.
 * @property int           $transfer      The monthly outbound transfer amount, in MB.
 * @property Price         $price         The default cost of provisioning this Linode Type. Prices are in US dollars,
 *                                        broken down into hourly and monthly charges.
 *                                        Certain Regions have different prices from the default. For Region-specific
 *                                        prices, see `region_prices`.
 * @property RegionPrice[] $region_prices
 * @property object        $addons        A list of optional add-on services for Linodes and their associated costs.
 * @property null|string   $successor     The Linode Type that a mutate will upgrade to for a Linode of this type. If
 *                                        "null", a Linode of this type may not mutate.
 */
class LinodeType extends Entity
{
    // Available fields.
    public const FIELD_ID            = 'id';
    public const FIELD_LABEL         = 'label';
    public const FIELD_CLASS         = 'class';
    public const FIELD_DISK          = 'disk';
    public const FIELD_MEMORY        = 'memory';
    public const FIELD_VCPUS         = 'vcpus';
    public const FIELD_GPUS          = 'gpus';
    public const FIELD_NETWORK_OUT   = 'network_out';
    public const FIELD_TRANSFER      = 'transfer';
    public const FIELD_PRICE         = 'price';
    public const FIELD_REGION_PRICES = 'region_prices';
    public const FIELD_ADDONS        = 'addons';
    public const FIELD_SUCCESSOR     = 'successor';

    // `FIELD_CLASS` values.
    public const CLASS_NANODE    = 'nanode';
    public const CLASS_STANDARD  = 'standard';
    public const CLASS_DEDICATED = 'dedicated';
    public const CLASS_PREMIUM   = 'premium';
    public const CLASS_GPU       = 'gpu';
    public const CLASS_HIGHMEM   = 'highmem';

    /**
     * @codeCoverageIgnore This method was autogenerated.
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            self::FIELD_PRICE         => new Price($this->client, $this->data[$name]),
            self::FIELD_REGION_PRICES => array_map(fn ($data) => new RegionPrice($this->client, $data), $this->data[$name]),
            default                   => parent::__get($name),
        };
    }
}
