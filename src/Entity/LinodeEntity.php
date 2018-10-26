<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity;

/**
 * Detailed information about the entity, including ID, type, label, and URL used to access it.
 *
 * @property int    $id    The unique ID for this Entity.
 * @property string $type  The type of entity this is related to.
 * @property string $label The current label of this object.
 * @property string $url   The URL where you can access the object this entity is for. If
 *                         a relative URL, it is relative to the domain you retrieved the
 *                         object from.
 */
class LinodeEntity extends Entity
{
}
