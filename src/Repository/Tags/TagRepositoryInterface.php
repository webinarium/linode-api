<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Repository\Tags;

use Linode\Entity\Tag;
use Linode\Repository\RepositoryInterface;

/**
 * Tag repository.
 */
interface TagRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a new Tag and optionally tags requested objects with it immediately.
     *
     * You must be an unrestricted User in order to add or modify Tags.
     *
     * @param array $parameters
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return Tag
     */
    public function create(array $parameters): Tag;

    /**
     * Remove a Tag from all objects and delete it.
     *
     * You must be an unrestricted User in order to add or modify Tags.
     *
     * @param string $label
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function delete(string $label): void;
}
