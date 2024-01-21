<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity\Linode;

use Linode\Entity\Entity;

/**
 * A dictionary of device disks to use as a device map in a Linode's configuration profile.
 *
 * @property Device $sda
 * @property Device $sdb
 * @property Device $sdc
 * @property Device $sdd
 * @property Device $sde
 * @property Device $sdf
 * @property Device $sdg
 * @property Device $sdh
 */
class Devices extends Entity
{
    // Available fields.
    public const FIELD_SDA = 'sda';
    public const FIELD_SDB = 'sdb';
    public const FIELD_SDC = 'sdc';
    public const FIELD_SDD = 'sdd';
    public const FIELD_SDE = 'sde';
    public const FIELD_SDF = 'sdf';
    public const FIELD_SDG = 'sdg';
    public const FIELD_SDH = 'sdh';

    public function __get(string $name): ?Device
    {
        if (array_key_exists($name, $this->data)) {
            return new Device($this->client, $this->data[$name]);
        }

        return null;
    }
}
