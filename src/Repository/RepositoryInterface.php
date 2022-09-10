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
    // Sort directions.
    public const SORT_ASC  = 'asc';
    public const SORT_DESC = 'desc';

    /**
     * Finds and returns an entity by its ID. If entity is not found, return `null`.
     *
     * @param int|string $id entity ID
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function find(int|string $id): Entity;

    /**
     * Finds all entities.
     *
     * @param null|string $orderBy  optional property name, which the collection should be sorted by
     * @param string      $orderDir optional sort direction (ignored when `orderBy` is `null`)
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function findAll(string $orderBy = null, string $orderDir = self::SORT_ASC): EntityCollection;

    /**
     * Finds entities by specified filters.
     *
     * @param array       $criteria list of filters
     * @param null|string $orderBy  optional property name, which the collection should be sorted by
     * @param string      $orderDir optional sort direction (ignored when `orderBy` is `null`)
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC): EntityCollection;

    /**
     * Finds an entity by specified filters. If entity is not found, return `null`.
     * If more than one entity is found, raises an exception.
     *
     * @param array $criteria list of filters
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function findOneBy(array $criteria): ?Entity;

    /**
     * Finds entities by specified query.
     *
     * @param string      $query      query string
     * @param array       $parameters query parameters
     * @param null|string $orderBy    optional property name, which the collection should be sorted by
     * @param string      $orderDir   optional sort direction (ignored when `orderBy` is `null`)
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC): EntityCollection;
}
