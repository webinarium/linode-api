<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use Linode\Entity\Account;
use Linode\Entity\Profile;
use Linode\Exception\LinodeException;
use Linode\Internal\Domains\DomainRepository;
use Linode\Internal\ImageRepository;
use Linode\Internal\KernelRepository;
use Linode\Internal\LinodeRepository;
use Linode\Internal\LinodeTypeRepository;
use Linode\Internal\Longview\LongviewSubscriptionRepository;
use Linode\Internal\Networking\IPAddressRepository;
use Linode\Internal\Networking\IPv6PoolRepository;
use Linode\Internal\Networking\IPv6RangeRepository;
use Linode\Internal\NodeBalancers\NodeBalancerRepository;
use Linode\Internal\ObjectStorage\ObjectStorageClusterRepository;
use Linode\Internal\ObjectStorage\ObjectStorageKeyRepository;
use Linode\Internal\RegionRepository;
use Linode\Internal\StackScriptRepository;
use Linode\Internal\Support\SupportTicketRepository;
use Linode\Internal\Tags\TagRepository;
use Linode\Internal\VolumeRepository;
use Psr\Http\Message\ResponseInterface;

/**
 * Linode API client.
 *
 * @property Entity\Account                                                   $account
 * @property Repository\Domains\DomainRepositoryInterface                     $domains
 * @property Repository\ImageRepositoryInterface                              $images
 * @property Repository\Networking\IPAddressRepositoryInterface               $ips
 * @property Repository\Networking\IPv6PoolRepositoryInterface                $ipv6_pools
 * @property Repository\Networking\IPv6RangeRepositoryInterface               $ipv6_ranges
 * @property Repository\KernelRepositoryInterface                             $kernels
 * @property Repository\LinodeRepositoryInterface                             $linodes
 * @property Repository\LinodeTypeRepositoryInterface                         $linode_types
 * @property Repository\Longview\LongviewSubscriptionRepositoryInterface      $longview_subscriptions
 * @property Repository\NodeBalancers\NodeBalancerRepositoryInterface         $node_balancers
 * @property Repository\ObjectStorage\ObjectStorageClusterRepositoryInterface $object_storage_clusters
 * @property Repository\ObjectStorage\ObjectStorageKeyRepositoryInterface     $object_storage_keys
 * @property Entity\Profile                                                   $profile
 * @property Repository\RegionRepositoryInterface                             $regions
 * @property Repository\StackScriptRepositoryInterface                        $stackscripts
 * @property Repository\Tags\TagRepositoryInterface                           $tags
 * @property Repository\Support\SupportTicketRepositoryInterface              $tickets
 * @property Repository\VolumeRepositoryInterface                             $volumes
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
    protected Client $client;

    /**
     * LinodeClient constructor.
     *
     * @param null|string $access_token API access token (PAT or retrieved via OAuth)
     */
    public function __construct(protected ?string $access_token = null)
    {
        $this->client = new Client();
    }

    /**
     * Returns specified repository.
     *
     * @param string $name repository name
     */
    public function __get(string $name): null|Account|Profile|Repository\RepositoryInterface
    {
        return match ($name) {
            'account'                 => new Account($this),
            'domains'                 => new DomainRepository($this),
            'images'                  => new ImageRepository($this),
            'ips'                     => new IPAddressRepository($this),
            'ipv6_pools'              => new IPv6PoolRepository($this),
            'ipv6_ranges'             => new IPv6RangeRepository($this),
            'kernels'                 => new KernelRepository($this),
            'linodes'                 => new LinodeRepository($this),
            'linode_types'            => new LinodeTypeRepository($this),
            'longview_subscriptions'  => new LongviewSubscriptionRepository($this),
            'node_balancers'          => new NodeBalancerRepository($this),
            'object_storage_clusters' => new ObjectStorageClusterRepository($this),
            'object_storage_keys'     => new ObjectStorageKeyRepository($this),
            'profile'                 => new Profile($this),
            'regions'                 => new RegionRepository($this),
            'stackscripts'            => new StackScriptRepository($this),
            'tags'                    => new TagRepository($this),
            'tickets'                 => new SupportTicketRepository($this),
            'volumes'                 => new VolumeRepository($this),
            default                   => null,
        };
    }

    /**
     * Performs a request to specified API endpoint.
     *
     * @param string $method     request method
     * @param string $uri        relative URI to API endpoint
     * @param array  $parameters optional parameters
     * @param array  $filters    optional filters
     *
     * @throws LinodeException
     */
    public function api(string $method, string $uri, array $parameters = [], array $filters = []): ResponseInterface
    {
        try {
            $options = [];

            if (null !== $this->access_token) {
                $options['headers']['Authorization'] = 'Bearer ' . $this->access_token;
            }

            if (0 !== count($filters) && self::REQUEST_GET === $method) {
                $options['headers']['X-Filter'] = json_encode($filters);
            }

            if (0 !== count($parameters)) {
                if (self::REQUEST_GET === $method) {
                    $options['query'] = $parameters;
                } elseif (self::REQUEST_POST === $method || self::REQUEST_PUT === $method) {
                    $options['json'] = $parameters;
                }
            }

            return $this->client->request($method, self::BASE_API_URI . $uri, $options);
        } catch (ClientException $exception) {
            throw new LinodeException($exception->getResponse());
        } catch (GuzzleException) {
            throw new LinodeException(new Response(500));
        }
    }
}
