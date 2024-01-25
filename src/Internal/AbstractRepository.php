<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal;

use GuzzleHttp\Psr7\Response;
use Linode\Entity;
use Linode\EntityCollection;
use Linode\Exception\LinodeException;
use Linode\LinodeClient;
use Linode\RepositoryInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * @internal An abstract Linode repository.
 */
abstract class AbstractRepository implements RepositoryInterface
{
    /**
     * @param LinodeClient $client Linode API client.
     */
    public function __construct(protected LinodeClient $client) {}

    public function find($id): ?Entity
    {
        $response = $this->client->get(sprintf('%s/%s', $this->getBaseUri(), $id));
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return $this->jsonToEntity($json);
    }

    public function findAll(string $orderBy = null, string $orderDir = self::SORT_ASC): EntityCollection
    {
        return $this->findBy([], $orderBy, $orderDir);
    }

    public function findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC): EntityCollection
    {
        if (null !== $orderBy) {
            $criteria['+order_by'] = $orderBy;
            $criteria['+order']    = $orderDir;
        }

        return new EntityCollection(
            fn (int $page) => $this->client->get($this->getBaseUri(), ['page' => $page], $criteria),
            fn (array $json) => $this->jsonToEntity($json)
        );
    }

    public function findOneBy(array $criteria): ?Entity
    {
        $collection = $this->findBy($criteria);

        if (0 === count($collection)) {
            return null;
        }

        if (1 !== count($collection)) {
            $errors = ['errors' => [['reason' => 'More than one entity was found']]];

            throw new LinodeException(new Response(LinodeClient::ERROR_BAD_REQUEST, [], json_encode($errors)));
        }

        return $collection->current();
    }

    public function query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC): EntityCollection
    {
        try {
            $parser   = new ExpressionLanguage();
            $compiler = new QueryCompiler();

            $query    = $compiler->apply($query, $parameters);
            $ast      = $parser->parse($query, $this->getSupportedFields())->getNodes();
            $criteria = $compiler->compile($ast);
        } catch (\Throwable $exception) {
            $errors = ['errors' => [['reason' => $exception->getMessage()]]];

            throw new LinodeException(new Response(LinodeClient::ERROR_BAD_REQUEST, [], json_encode($errors)));
        }

        return $this->findBy($criteria, $orderBy, $orderDir);
    }

    /**
     * Verifies that all specified parameters are supported by the repository.
     * An exception is raised when unsupported parameter was found.
     *
     * @throws LinodeException
     */
    protected function checkParametersSupport(array $parameters): void
    {
        $supported = $this->getSupportedFields();
        $provided  = array_keys($parameters);

        $unknown = array_diff($provided, $supported);

        if (0 !== count($unknown)) {
            $errors = ['errors' => [['reason' => sprintf('Unknown field(s): %s', implode(', ', $unknown))]]];

            throw new LinodeException(new Response(LinodeClient::ERROR_BAD_REQUEST, [], json_encode($errors)));
        }
    }

    /**
     * Returns base URI to the repository-specific API.
     */
    abstract protected function getBaseUri(): string;

    /**
     * Returns list of all fields (entity properties) supported by the repository.
     *
     * @return string[]
     */
    abstract protected function getSupportedFields(): array;

    /**
     * Creates a repository-specific entity using specified JSON data.
     */
    abstract protected function jsonToEntity(array $json): Entity;
}
