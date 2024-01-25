<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode;

use Linode\Exception\LinodeException;

/**
 * A repository to work with Linode entities of the same type.
 */
interface RepositoryInterface
{
    // Sort directions.
    public const SORT_ASC  = 'asc';
    public const SORT_DESC = 'desc';

    /**
     * Finds and returns an entity by its ID. If entity is not found, returns `null`.
     *
     * @param int|string $id Entity ID.
     *
     * @throws LinodeException
     */
    public function find(int|string $id): ?Entity;

    /**
     * Finds all entities.
     *
     * @param null|string $orderBy  Optional property name, which the collection should be sorted by.
     * @param string      $orderDir Optional sort direction (ignored when `orderBy` is `null`).
     *
     * @throws LinodeException
     */
    public function findAll(string $orderBy = null, string $orderDir = self::SORT_ASC): EntityCollection;

    /**
     * Finds entities by specified filters.
     *
     * @param array       $criteria List of filters.
     * @param null|string $orderBy  Optional property name, which the collection should be sorted by.
     * @param string      $orderDir Optional sort direction (ignored when `orderBy` is `null`).
     *
     * @throws LinodeException
     */
    public function findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC): EntityCollection;

    /**
     * Finds an entity by specified filters. If entity is not found, returns `null`.
     * If more than one entity is found, raises an exception.
     *
     * @param array $criteria List of filters.
     *
     * @throws LinodeException
     */
    public function findOneBy(array $criteria): ?Entity;

    /**
     * Finds entities by specified query.
     *
     * @param string      $query      Query string.
     * @param array       $parameters Query parameters.
     * @param null|string $orderBy    Optional property name, which the collection should be sorted by.
     * @param string      $orderDir   Optional sort direction (ignored when `orderBy` is `null`).
     *
     * @throws LinodeException
     */
    public function query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC): EntityCollection;
}
