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
 * @property Account\Account                                       $account
 * @property Databases\DatabaseRepositoryInterface                 $databases
 * @property Databases\DatabaseEngineRepositoryInterface           $databaseEngines
 * @property Databases\DatabaseTypeRepositoryInterface             $databaseTypes
 * @property Databases\DatabaseMongoDBRepositoryInterface          $databasesMongoDB
 * @property Databases\DatabaseMySQLRepositoryInterface            $databasesMySQL
 * @property Databases\DatabasePostgreSQLRepositoryInterface       $databasesPostgreSQL
 * @property Domains\DomainRepositoryInterface                     $domains
 * @property Networking\FirewallRepositoryInterface                $firewalls
 * @property Images\ImageRepositoryInterface                       $images
 * @property LinodeInstances\KernelRepositoryInterface             $kernels
 * @property LinodeInstances\LinodeRepositoryInterface             $linodes
 * @property LinodeTypes\LinodeTypeRepositoryInterface             $linodeTypes
 * @property LKE\LKEClusterRepositoryInterface                     $lkeClusters
 * @property LKE\LKEVersionRepositoryInterface                     $lkeVersions
 * @property Longview\LongviewClientRepositoryInterface            $longviewClients
 * @property Longview\LongviewSubscriptionRepositoryInterface      $longviewSubscriptions
 * @property Managed\ManagedContactRepositoryInterface             $managedContacts
 * @property Managed\ManagedCredentialRepositoryInterface          $managedCredentials
 * @property Managed\ManagedIssueRepositoryInterface               $managedIssues
 * @property Managed\ManagedLinodeSettingsRepositoryInterface      $managedLinodeSettings
 * @property Managed\ManagedServiceRepositoryInterface             $managedServices
 * @property Networking\IPAddressRepositoryInterface               $ipAddresses
 * @property Networking\IPv6PoolRepositoryInterface                $ipv6Pools
 * @property Networking\IPv6RangeRepositoryInterface               $ipv6Ranges
 * @property NodeBalancers\NodeBalancerRepositoryInterface         $nodeBalancers
 * @property ObjectStorage\ObjectStorageClusterRepositoryInterface $objectStorageClusters
 * @property ObjectStorage\ObjectStorageKeyRepositoryInterface     $objectStorageKeys
 * @property Profile\Profile                                       $profile
 * @property Regions\RegionRepositoryInterface                     $regions
 * @property StackScripts\StackScriptRepositoryInterface           $stackScripts
 * @property Support\SupportTicketRepositoryInterface              $supportTickets
 * @property Tags\TagRepositoryInterface                           $tags
 * @property Volumes\VolumeRepositoryInterface                     $volumes
 * @property Networking\VlansRepositoryInterface                   $vlans
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
    public const SUCCESS_ACCEPTED   = 202;
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
     *
     * @throws LinodeException
     */
    public function __get(string $name): null|Account\Account|Profile\Profile|RepositoryInterface
    {
        return match ($name) {
            'account'               => new Account\Account($this),
            'databases'             => new Databases\Repository\DatabaseRepository($this),
            'databaseEngines'       => new Databases\Repository\DatabaseEngineRepository($this),
            'databaseTypes'         => new Databases\Repository\DatabaseTypeRepository($this),
            'databasesMongoDB'      => new Databases\Repository\DatabaseMongoDBRepository($this),
            'databasesMySQL'        => new Databases\Repository\DatabaseMySQLRepository($this),
            'databasesPostgreSQL'   => new Databases\Repository\DatabasePostgreSQLRepository($this),
            'domains'               => new Domains\Repository\DomainRepository($this),
            'firewalls'             => new Networking\Repository\FirewallRepository($this),
            'images'                => new Images\Repository\ImageRepository($this),
            'kernels'               => new LinodeInstances\Repository\KernelRepository($this),
            'linodes'               => new LinodeInstances\Repository\LinodeRepository($this),
            'linodeTypes'           => new LinodeTypes\Repository\LinodeTypeRepository($this),
            'lkeClusters'           => new LKE\Repository\LKEClusterRepository($this),
            'lkeVersions'           => new LKE\Repository\LKEVersionRepository($this),
            'longviewClients'       => new Longview\Repository\LongviewClientRepository($this),
            'longviewSubscriptions' => new Longview\Repository\LongviewSubscriptionRepository($this),
            'managedContacts'       => new Managed\Repository\ManagedContactRepository($this),
            'managedCredentials'    => new Managed\Repository\ManagedCredentialRepository($this),
            'managedIssues'         => new Managed\Repository\ManagedIssueRepository($this),
            'managedLinodeSettings' => new Managed\Repository\ManagedLinodeSettingsRepository($this),
            'managedServices'       => new Managed\Repository\ManagedServiceRepository($this),
            'ipAddresses'           => new Networking\Repository\IPAddressRepository($this),
            'ipv6Pools'             => new Networking\Repository\IPv6PoolRepository($this),
            'ipv6Ranges'            => new Networking\Repository\IPv6RangeRepository($this),
            'nodeBalancers'         => new NodeBalancers\Repository\NodeBalancerRepository($this),
            'objectStorageClusters' => new ObjectStorage\Repository\ObjectStorageClusterRepository($this),
            'objectStorageKeys'     => new ObjectStorage\Repository\ObjectStorageKeyRepository($this),
            'profile'               => new Profile\Profile($this),
            'regions'               => new Regions\Repository\RegionRepository($this),
            'stackScripts'          => new StackScripts\Repository\StackScriptRepository($this),
            'supportTickets'        => new Support\Repository\SupportTicketRepository($this),
            'tags'                  => new Tags\Repository\TagRepository($this),
            'vlans'                 => new Networking\Repository\VlansRepository($this),
            'volumes'               => new Volumes\Repository\VolumeRepository($this),
            default                 => null,
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
     * @param string $uri     Relative URI to the API endpoint.
     * @param array  $body    Request body.
     * @param array  $options Custom request options.
     *
     * @throws LinodeException
     */
    public function post(string $uri, array $body = [], array $options = []): ResponseInterface
    {
        if (0 !== count($body) && 0 === count($options)) {
            $options['json'] = array_filter($body, static fn ($value) => null !== $value);
        }

        return $this->api(self::REQUEST_POST, $uri, $options);
    }

    /**
     * Performs a PUT request to specified API endpoint.
     *
     * @param string $uri     Relative URI to the API endpoint.
     * @param array  $body    Request body.
     * @param array  $options Custom request options.
     *
     * @throws LinodeException
     */
    public function put(string $uri, array $body = [], array $options = []): ResponseInterface
    {
        if (0 !== count($body) && 0 === count($options)) {
            $options['json'] = array_filter($body, static fn ($value) => null !== $value);
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
