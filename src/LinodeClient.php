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

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use Linode\Exception\LinodeException;
use Psr\Http\Message\ResponseInterface;

/**
 * Linode API client.
 *
 * @property Regions\RegionRepositoryInterface $regions
 */
class LinodeClient
{
    // Request methods.
    public const REQUEST_GET    = 'GET';
    public const REQUEST_POST   = 'POST';
    public const REQUEST_PUT    = 'PUT';
    public const REQUEST_DELETE = 'DELETE';

    // Response success codes.
    public const SUCCESS_OK         = 200;
    public const SUCCESS_NO_CONTENT = 204;

    // Response error codes.
    public const ERROR_BAD_REQUEST           = 400;
    public const ERROR_UNAUTHORIZED          = 401;
    public const ERROR_FORBIDDEN             = 403;
    public const ERROR_NOT_FOUND             = 404;
    public const ERROR_TOO_MANY_REQUESTS     = 429;
    public const ERROR_INTERNAL_SERVER_ERROR = 500;

    // Base URI to Linode API.
    protected const BASE_API_URI = 'https://api.linode.com/v4';

    /** @var ClientInterface HTTP client. */
    protected ClientInterface $client;

    /**
     * @param null|string $access_token API access token (PAT or retrieved via OAuth).
     */
    public function __construct(protected ?string $access_token = null)
    {
        $this->client = new Client();
    }

    /**
     * Returns specified repository.
     *
     * @param string $name Repository name.
     */
    public function __get(string $name): null|RepositoryInterface
    {
        return match ($name) {
            'regions' => new Regions\Repository\RegionRepository($this),
            default   => null,
        };
    }

    /**
     * Performs a GET request to specified API endpoint.
     *
     * @param string $uri     Relative URI to the API endpoint.
     * @param array  $body    Request body.
     * @param array  $filters Pagination options.
     *
     * @throws LinodeException
     */
    public function get(string $uri, array $body = [], array $filters = []): ResponseInterface
    {
        $options = [];

        if (0 !== count($filters)) {
            $options['headers']['X-Filter'] = json_encode($filters);
        }

        if (0 !== count($body)) {
            $options['query'] = $body;
        }

        return $this->api(self::REQUEST_GET, $uri, $options);
    }

    /**
     * Performs a POST request to specified API endpoint.
     *
     * @param string $uri  Relative URI to the API endpoint.
     * @param array  $body Request body.
     *
     * @throws LinodeException
     */
    public function post(string $uri, array $body = []): ResponseInterface
    {
        $options = [];

        if (0 !== count($body)) {
            $options['json'] = $body;
        }

        return $this->api(self::REQUEST_POST, $uri, $options);
    }

    /**
     * Performs a PUT request to specified API endpoint.
     *
     * @param string $uri  Relative URI to the API endpoint.
     * @param array  $body Request body.
     *
     * @throws LinodeException
     */
    public function put(string $uri, array $body = []): ResponseInterface
    {
        $options = [];

        if (0 !== count($body)) {
            $options['json'] = $body;
        }

        return $this->api(self::REQUEST_PUT, $uri, $options);
    }

    /**
     * Performs a DELETE request to specified API endpoint.
     *
     * @param string $uri Relative URI to the API endpoint.
     *
     * @throws LinodeException
     */
    public function delete(string $uri): ResponseInterface
    {
        return $this->api(self::REQUEST_DELETE, $uri);
    }

    /**
     * Performs a request to specified API endpoint.
     *
     * @param string $method  Request method.
     * @param string $uri     Relative URI to request bodyAPI endpoint.
     * @param array  $options Request options.
     *
     * @throws LinodeException
     */
    protected function api(string $method, string $uri, array $options = []): ResponseInterface
    {
        try {
            if (null !== $this->access_token) {
                $options['headers']['Authorization'] = 'Bearer ' . $this->access_token;
            }

            return $this->client->request($method, self::BASE_API_URI . $uri, $options);
        } catch (ClientException $exception) {
            throw new LinodeException($exception->getResponse());
        } catch (GuzzleException) {
            throw new LinodeException(new Response(500));
        }
    }
}
