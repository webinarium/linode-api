<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use Linode\Exception\LinodeException;
use Psr\Http\Message\ResponseInterface;

/**
 * A trait to make API calls.
 */
trait ApiTrait
{
    /** @var Client HTTP client. */
    protected $client;

    /** @var string Base URI to the API endpoint. */
    protected $base_uri;

    /** @var null|string API access token (PAT or retrieved via OAuth). */
    protected $access_token;

    /**
     * Performs a request to specified API endpoint.
     *
     * @param string $method     Request method.
     * @param string $uri        API endpoint.
     * @param array  $parameters Optional parameters.
     * @param array  $filters    Optional filters.
     *
     * @throws LinodeException
     *
     * @return ResponseInterface
     */
    protected function api(string $method, string $uri, array $parameters = [], array $filters = []): ResponseInterface
    {
        try {

            if ($this->client === null) {
                $this->client = new Client();
            }

            $options = [];

            if ($this->access_token !== null) {
                $options['headers']['Authorization'] = 'Bearer ' . $this->access_token;
            }

            if (count($filters) !== 0 && $method === 'GET') {
                $options['headers']['X-Filter'] = json_encode($filters);
            }

            if (count($parameters) !== 0) {
                if ($method === 'GET') {
                    $options['query'] = $parameters;
                }
                elseif ($method === 'POST' || $method === 'PUT') {
                    $options['json'] = $parameters;
                }
            }

            return $this->client->request($method, $this->base_uri . $uri, $options);
        }
        catch (ClientException $exception) {
            throw new LinodeException($exception->getResponse());
        }
        catch (GuzzleException $exception) {
            throw new LinodeException(new Response(500));
        }
    }
}
