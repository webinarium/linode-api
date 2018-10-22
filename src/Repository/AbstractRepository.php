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
use Linode\Internal\ApiTrait;

/**
 * An abstract Linode repository.
 */
abstract class AbstractRepository implements RepositoryInterface
{
    use ApiTrait;

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

    // Request methods.
    protected const REQUEST_GET    = 'GET';
    protected const REQUEST_POST   = 'POST';
    protected const REQUEST_PUT    = 'PUT';
    protected const REQUEST_DELETE = 'DELETE';

    /**
     * AbstractRepository constructor.
     *
     * @param null|string $access_token API access token (PAT or retrieved via OAuth).
     */
    public function __construct(string $access_token = null)
    {
        $this->base_uri     = 'https://api.linode.com/v4';
        $this->access_token = $access_token;
    }

    /**
     * {@inheritdoc}
     */
    public function find($id): ?Entity
    {
        $response = $this->api(self::REQUEST_GET, '/' . $id);
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
                return $this->api(self::REQUEST_GET, '', ['page' => $page], $criteria);
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
     * Creates a repository-specific entity using specified JSON data.
     *
     * @param array $json
     *
     * @return Entity
     */
    abstract protected function jsonToEntity(array $json): Entity;
}
