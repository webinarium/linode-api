<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Tags;

use Linode\Exception\LinodeException;
use Linode\RepositoryInterface;

/**
 * Tag repository.
 *
 * @method Tag   find(int|string $id)
 * @method Tag[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Tag[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Tag   findOneBy(array $criteria)
 * @method Tag[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface TagRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a new Tag and optionally tags requested objects with it immediately.
     *
     * **Important**: You must be an unrestricted User in order to access, add, or modify
     * Tags information.
     *
     * @param array $parameters The tag to create, and optionally the objects to tag.
     *
     * @throws LinodeException
     */
    public function createTag(array $parameters = []): Tag;

    /**
     * Remove a Tag from all objects and delete it.
     *
     * **Important**: You must be an unrestricted User in order to access, add, or modify
     * Tags information.
     *
     * @throws LinodeException
     */
    public function deleteTag(string $label): void;
}
