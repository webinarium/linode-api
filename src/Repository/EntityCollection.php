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
    protected $currentPage;

    /** @var int Total number of pages. */
    protected $totalPages;

    /** @var int Total number of entities. */
    protected $totalEntities;

    /** @var int Number of loaded entities. */
    protected $loadedEntities;

    /** @var \SplFixedArray Entities (JSON objects). */
    protected $entitiesData;

    /**
     * EntityCollection constructor.
     *
     * @param callable $apiHandler    Function to make an API call (@see ApiTrait::api()).
     * @param callable $entityFactory Function to create entities using JSON (@see AbstractRepository::jsonToEntity()).
     */
    public function __construct(callable $apiHandler, callable $entityFactory)
    {
        $this->apiHandler    = $apiHandler;
        $this->entityFactory = $entityFactory;

        $this->currentPage    = 0;
        $this->totalPages     = 0;
        $this->totalEntities  = 0;
        $this->loadedEntities = 0;
        $this->entitiesData   = null;

        $this->loadPage();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->totalEntities;
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->entitiesData->key();
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        $json = $this->entitiesData->current();

        return ($this->entityFactory)($json);
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->entitiesData->valid();
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->entitiesData->next();

        if ($this->entitiesData->key() >= $this->loadedEntities && $this->loadedEntities < $this->totalEntities) {
            $this->loadPage();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->entitiesData->rewind();
    }

    /**
     * Loads next page of data.
     */
    protected function loadPage()
    {
        /** @var \Psr\Http\Message\ResponseInterface $response */
        $response = ($this->apiHandler)(++$this->currentPage);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        // Whether we are loading for the first time.
        if ($this->entitiesData === null) {

            $this->totalPages    = $json['pages']   ?? 1;
            $this->totalEntities = $json['results'] ?? 0;

            $this->entitiesData = new \SplFixedArray($this->totalEntities);
        }

        foreach ($json['data'] ?? [] as $entry) {
            $this->entitiesData[$this->loadedEntities++] = $entry;
        }
    }
}
