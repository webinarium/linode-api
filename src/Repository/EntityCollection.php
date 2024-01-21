<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Repository;

use Psr\Http\Message\ResponseInterface;

/**
 * A collection of entities.
 */
class EntityCollection implements \Countable, \Iterator
{
    /** @var callable */
    protected $apiHandler;

    /** @var callable */
    protected $entityFactory;

    /** @var int Current page (one-based index). */
    protected int $currentPage;

    /** @var int Current entity (zero-based index). */
    protected int $currentEntity;

    /** @var int Total number of pages. */
    protected int $totalPages;

    /** @var int Total number of entities. */
    protected int $totalEntities;

    /** @var int Number of loaded entities. */
    protected int $loadedEntities;

    /** @var null|\SplFixedArray Entities (JSON objects). */
    protected ?\SplFixedArray $entitiesData;

    /**
     * EntityCollection constructor.
     *
     * @param callable $apiHandler    function to make an API call (@see ApiTrait::api())
     * @param callable $entityFactory function to create entities using JSON (@see AbstractRepository::jsonToEntity())
     */
    public function __construct(callable $apiHandler, callable $entityFactory)
    {
        $this->apiHandler    = $apiHandler;
        $this->entityFactory = $entityFactory;

        $this->currentPage    = 0;
        $this->currentEntity  = 0;
        $this->totalPages     = 0;
        $this->totalEntities  = 0;
        $this->loadedEntities = 0;
        $this->entitiesData   = null;

        $this->loadPage();
    }

    public function count(): int
    {
        return $this->totalEntities;
    }

    public function key(): int
    {
        return $this->currentEntity;
    }

    public function current(): mixed
    {
        $json = $this->entitiesData[$this->currentEntity];

        return ($this->entityFactory)($json);
    }

    public function valid(): bool
    {
        return $this->currentEntity >= 0 && $this->currentEntity < $this->totalEntities;
    }

    public function next(): void
    {
        $this->currentEntity++;

        if ($this->currentEntity >= $this->loadedEntities && $this->loadedEntities < $this->totalEntities) {
            $this->loadPage();
        }
    }

    public function rewind(): void
    {
        $this->currentEntity = 0;
    }

    /**
     * Loads next page of data.
     */
    protected function loadPage(): void
    {
        /** @var ResponseInterface $response */
        $response = ($this->apiHandler)(++$this->currentPage);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        // Whether we are loading for the first time.
        if (null === $this->entitiesData) {
            $this->totalPages    = $json['pages']   ?? 1;
            $this->totalEntities = $json['results'] ?? 0;

            $this->entitiesData = new \SplFixedArray($this->totalEntities);
        }

        foreach ($json['data'] ?? [] as $entry) {
            $this->entitiesData[$this->loadedEntities++] = $entry;
        }
    }
}
