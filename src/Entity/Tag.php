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

use Linode\Internal\Tags\TaggedObjectRepository;
use Linode\Repository\Tags\TaggedObjectRepositoryInterface;

/**
 * A tag that has been applied to an object on your Account. Tags are
 * currently for organizational purposes only.
 *
 * @property string                          $label   A Label used for organization of objects on your Account.
 * @property TaggedObjectRepositoryInterface $objects Tagged objects.
 */
class Tag extends Entity
{
    // Available fields.
    public const FIELD_LABEL          = 'label';
    public const FIELD_LINODES        = 'linodes';
    public const FIELD_DOMAINS        = 'domains';
    public const FIELD_VOLUMES        = 'volumes';
    public const FIELD_NODE_BALANCERS = 'nodebalancers';

    public function __get(string $name): mixed
    {
        return match ($name) {
            'objects' => new TaggedObjectRepository($this->client, $this->label),
            default   => parent::__get($name),
        };
    }
}
