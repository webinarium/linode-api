<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\LKE;

use Linode\Entity;

/**
 * The number of nodes autoscales within the defined minimum and maximum values.
 *
 * @property bool $enabled Whether autoscaling is enabled for this Node Pool. Defaults to `false`.
 * @property int  $min     The minimum number of nodes to autoscale to. Defaults to the Node Pool's `count`.
 * @property int  $max     The maximum number of nodes to autoscale to. Defaults to the Node Pool's `count`.
 */
class Autoscaler extends Entity {}
