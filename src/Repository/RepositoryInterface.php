<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Repository;

use Linode\Entity\Entity;

/**
 * A repository to work with Linode entities of the same type.
 */
interface RepositoryInterface
{
    /**
     * Finds and returns an entity by its ID. If entity is not found, return `null`.
     *
     * @param int|string $id Entity ID.
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return null|Entity
     */
    public function find($id): ?Entity;
}
