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

use Linode\Internal\Tags\TaggedObjectRepository;

/**
 * A tag that has been applied to an object on your Account. Tags are
 * currently for organizational purposes only.
 *
 * @property string $label A Label used for organization of objects on your Account.
 * @property \Linode\Repository\Tags\TaggedObjectRepositoryInterface $objects Tagged objects.
 */
class Tag extends Entity
{
    // Available fields.
    public const FIELD_LABEL = 'label';

    /**
     * {@inheritdoc}
     */
    public function __get(string $name)
    {
        if ($name === 'objects') {
            return new TaggedObjectRepository($this->client, $this->label);
        }

        return parent::__get($name);
    }
}
