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
 * LKE versions.
 *
 * @property string $id A Kubernetes version number available for deployment to a Kubernetes cluster in
 *                      the format of <major>.<minor>, and the latest supported patch version.
 */
class LKEVersion extends Entity
{
    // Available fields.
    public const FIELD_ID = 'id';
}
