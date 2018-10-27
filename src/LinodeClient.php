<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use Linode\Entity\Account;
use Linode\Exception\LinodeException;
use Linode\Internal\Domains\DomainRepository;
use Linode\Internal\KernelRepository;
use Linode\Internal\LinodeTypeRepository;
use Linode\Internal\Networking\IPAddressRepository;
use Linode\Internal\Networking\IPv6PoolRepository;
use Linode\Internal\Networking\IPv6RangeRepository;
use Linode\Internal\RegionRepository;
use Psr\Http\Message\ResponseInterface;

/**
 * Linode API client.
 *
 * @property Entity\Account                                     $account
 * @property Repository\Domains\DomainRepositoryInterface       $domains
 * @property Repository\Networking\IPAddressRepositoryInterface $ips
 * @property Repository\Networking\IPv6PoolRepositoryInterface  $ipv6_pools
 * @property Repository\Networking\IPv6RangeRepositoryInterface $ipv6_ranges
 * @property Repository\KernelRepositoryInterface               $kernels
 * @property Repository\LinodeTypeRepositoryInterface           $linode_types
 * @property Repository\RegionRepositoryInterface               $regions
 */
class LinodeClient
{
    // Request methods.
    public const REQUEST_GET    = 'GET';
    public const REQUEST_POST   = 'POST';
    public const REQUEST_PUT    = 'PUT';
    public const REQUEST_DELETE = 'DELETE';

    // Base URI to Linode API.
    protected const BASE_API_URI = 'https://api.linode.com/v4';

    /** @var Client HTTP client. */
    protected $client;

    /** @var null|string API access token (PAT or retrieved via OAuth). */
    protected $access_token;

    /**
     * LinodeClient constructor.
     *
     * @param null|string $access_token API access token (PAT or retrieved via OAuth).
     */
    public function __construct(string $access_token = null)
    {
        $this->client       = new Client();
        $this->access_token = $access_token;
    }

    /**
     * Returns specified repository.
     *
     * @param string $name Repository name.
     *
     * @return null|Account|Repository\RepositoryInterface
     */
    public function __get(string $name)
    {
        switch ($name) {

            case 'account':
                return new Account($this);

            case 'domains':
                return new DomainRepository($this);

            case 'ips':
                return new IPAddressRepository($this);

            case 'ipv6_pools':
                return new IPv6PoolRepository($this);

            case 'ipv6_ranges':
                return new IPv6RangeRepository($this);

            case 'kernels':
                return new KernelRepository($this);

            case 'linode_types':
                return new LinodeTypeRepository($this);

            case 'regions':
                return new RegionRepository($this);
        }

        return null;
    }

    /**
     * Performs a request to specified API endpoint.
     *
     * @param string $method     Request method.
     * @param string $uri        Relative URI to API endpoint.
     * @param array  $parameters Optional parameters.
     * @param array  $filters    Optional filters.
     *
     * @throws LinodeException
     *
     * @return ResponseInterface
     */
    public function api(string $method, string $uri, array $parameters = [], array $filters = []): ResponseInterface
    {
        try {
            $options = [];

            if ($this->access_token !== null) {
                $options['headers']['Authorization'] = 'Bearer ' . $this->access_token;
            }

            if (count($filters) !== 0 && $method === self::REQUEST_GET) {
                $options['headers']['X-Filter'] = json_encode($filters);
            }

            if (count($parameters) !== 0) {
                if ($method === self::REQUEST_GET) {
                    $options['query'] = $parameters;
                }
                elseif ($method === self::REQUEST_POST || $method === self::REQUEST_PUT) {
                    $options['json'] = $parameters;
                }
            }

            return $this->client->request($method, self::BASE_API_URI . $uri, $options);
        }
        catch (ClientException $exception) {
            throw new LinodeException($exception->getResponse());
        }
        catch (GuzzleException $exception) {
            throw new LinodeException(new Response(500));
        }
    }
}
