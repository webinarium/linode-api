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
 * Kubernetes Control Plane settings.
 *
 * @property bool $high_availability Defines whether High Availability is enabled for the Control Plane Components of
 *                                   the cluster. Defaults to `false`.
 */
class KubernetesControlPlane extends Entity {}
