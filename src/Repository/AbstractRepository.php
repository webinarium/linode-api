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

use GuzzleHttp\Psr7\Response;
use Linode\Entity\Entity;
use Linode\Exception\LinodeException;
use Linode\Internal\QueryCompiler;
use Linode\LinodeClient;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * An abstract Linode repository.
 */
abstract class AbstractRepository implements RepositoryInterface
{
    // Response error codes.
    public const ERROR_BAD_REQUEST           = 400;
    public const ERROR_UNAUTHORIZED          = 401;
    public const ERROR_FORBIDDEN             = 403;
    public const ERROR_NOT_FOUND             = 404;
    public const ERROR_TOO_MANY_REQUESTS     = 429;
    public const ERROR_INTERNAL_SERVER_ERROR = 500;

    // Response success codes.
    protected const SUCCESS_OK         = 200;
    protected const SUCCESS_NO_CONTENT = 204;

    // Base URI to the repository-specific API.
    protected const BASE_API_URI = '';

    /** @var LinodeClient */
    protected $client;

    /**
     * AbstractRepository constructor.
     *
     * @param LinodeClient $client Linode API client.
     */
    public function __construct(LinodeClient $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function find($id): ?Entity
    {
        $response = $this->client->api($this->client::REQUEST_GET, static::BASE_API_URI . '/' . $id);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return $this->jsonToEntity($json);
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(string $orderBy = null, string $orderDir = self::SORT_ASC): LinodeCollection
    {
        return $this->findBy([], $orderBy, $orderDir);
    }

    /**
     * {@inheritdoc}
     */
    public function findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC): LinodeCollection
    {
        if ($orderBy !== null) {
            $criteria['+order_by'] = $orderBy;
            $criteria['+order']    = $orderDir;
        }

        return new LinodeCollection(
            function (int $page) use ($criteria) {
                return $this->client->api($this->client::REQUEST_GET, static::BASE_API_URI, ['page' => $page], $criteria);
            },
            function (array $json) {
                return $this->jsonToEntity($json);
            });
    }

    /**
     * {@inheritdoc}
     */
    public function findOneBy(array $criteria): ?Entity
    {
        $collection = $this->findBy($criteria);

        if (count($collection) === 0) {
            return null;
        }

        if (count($collection) !== 1) {
            $errors = ['errors' => [['reason' => 'More than one entity was found']]];
            throw new LinodeException(new Response(self::ERROR_BAD_REQUEST, [], json_encode($errors)));
        }

        return $collection->current();
    }

    /**
     * {@inheritdoc}
     */
    public function query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC): LinodeCollection
    {
        try {
            $parser   = new ExpressionLanguage();
            $compiler = new QueryCompiler();

            $query    = $compiler->apply($query, $parameters);
            $ast      = $parser->parse($query, $this->getSupportedFields())->getNodes();
            $criteria = $compiler->compile($ast);
        }
        catch (\Throwable $exception) {
            $errors = ['errors' => [['reason' => $exception->getMessage()]]];
            throw new LinodeException(new Response(self::ERROR_BAD_REQUEST, [], json_encode($errors)));
        }

        return $this->findBy($criteria, $orderBy, $orderDir);
    }

    /**
     * Returns list of all fields (entity properties) supported by the repository.
     *
     * @return string[]
     */
    abstract protected function getSupportedFields(): array;

    /**
     * Creates a repository-specific entity using specified JSON data.
     *
     * @param array $json
     *
     * @return Entity
     */
    abstract protected function jsonToEntity(array $json): Entity;
}
