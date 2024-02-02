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
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Linode\BetaPrograms\BetaProgramRepositoryInterface;
use Linode\Databases\DatabaseEngineRepositoryInterface;
use Linode\Databases\DatabaseMySQLRepositoryInterface;
use Linode\Databases\DatabasePostgreSQLRepositoryInterface;
use Linode\Databases\DatabaseRepositoryInterface;
use Linode\Databases\DatabaseTypeRepositoryInterface;
use Linode\Domains\DomainRepositoryInterface;
use Linode\Exception\LinodeException;
use Linode\Images\ImageRepositoryInterface;
use Linode\LinodeInstances\KernelRepositoryInterface;
use Linode\LinodeInstances\LinodeRepositoryInterface;
use Linode\LinodeTypes\LinodeTypeRepositoryInterface;
use Linode\LKE\LKEClusterRepositoryInterface;
use Linode\LKE\LKEVersionRepositoryInterface;
use Linode\Longview\LongviewClientRepositoryInterface;
use Linode\Longview\LongviewSubscriptionRepositoryInterface;
use Linode\Managed\ManagedContactRepositoryInterface;
use Linode\Managed\ManagedCredentialRepositoryInterface;
use Linode\Managed\ManagedIssueRepositoryInterface;
use Linode\Managed\ManagedLinodeSettingsRepositoryInterface;
use Linode\Managed\ManagedServiceRepositoryInterface;
use Linode\Networking\FirewallRepositoryInterface;
use Linode\Networking\IPAddressRepositoryInterface;
use Linode\Networking\IPv6PoolRepositoryInterface;
use Linode\Networking\IPv6RangeRepositoryInterface;
use Linode\Networking\VlansRepositoryInterface;
use Linode\NodeBalancers\NodeBalancerRepositoryInterface;
use Linode\ObjectStorage\ObjectStorageClusterRepositoryInterface;
use Linode\ObjectStorage\ObjectStorageKeyRepositoryInterface;
use Linode\Regions\RegionRepositoryInterface;
use Linode\StackScripts\StackScriptRepositoryInterface;
use Linode\Support\SupportTicketRepositoryInterface;
use Linode\Tags\TagRepositoryInterface;
use Linode\Volumes\VolumeRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\LinodeClient
 */
final class LinodeClientTest extends TestCase
{
    use ReflectionTrait;

    /**
     * @covers ::__construct
     * @covers ::__get
     */
    public function testProperties(): void
    {
        $object = new LinodeClient();

        self::assertInstanceOf(BetaProgramRepositoryInterface::class, $object->betaPrograms);
        self::assertInstanceOf(DatabaseRepositoryInterface::class, $object->databases);
        self::assertInstanceOf(DatabaseEngineRepositoryInterface::class, $object->databaseEngines);
        self::assertInstanceOf(DatabaseTypeRepositoryInterface::class, $object->databaseTypes);
        self::assertInstanceOf(DatabaseMySQLRepositoryInterface::class, $object->databasesMySQL);
        self::assertInstanceOf(DatabasePostgreSQLRepositoryInterface::class, $object->databasesPostgreSQL);
        self::assertInstanceOf(DomainRepositoryInterface::class, $object->domains);
        self::assertInstanceOf(FirewallRepositoryInterface::class, $object->firewalls);
        self::assertInstanceOf(ImageRepositoryInterface::class, $object->images);
        self::assertInstanceOf(KernelRepositoryInterface::class, $object->kernels);
        self::assertInstanceOf(LinodeRepositoryInterface::class, $object->linodes);
        self::assertInstanceOf(LinodeTypeRepositoryInterface::class, $object->linodeTypes);
        self::assertInstanceOf(LKEClusterRepositoryInterface::class, $object->lkeClusters);
        self::assertInstanceOf(LKEVersionRepositoryInterface::class, $object->lkeVersions);
        self::assertInstanceOf(LongviewClientRepositoryInterface::class, $object->longviewClients);
        self::assertInstanceOf(LongviewSubscriptionRepositoryInterface::class, $object->longviewSubscriptions);
        self::assertInstanceOf(ManagedContactRepositoryInterface::class, $object->managedContacts);
        self::assertInstanceOf(ManagedCredentialRepositoryInterface::class, $object->managedCredentials);
        self::assertInstanceOf(ManagedIssueRepositoryInterface::class, $object->managedIssues);
        self::assertInstanceOf(ManagedLinodeSettingsRepositoryInterface::class, $object->managedLinodeSettings);
        self::assertInstanceOf(ManagedServiceRepositoryInterface::class, $object->managedServices);
        self::assertInstanceOf(IPAddressRepositoryInterface::class, $object->ipAddresses);
        self::assertInstanceOf(IPv6PoolRepositoryInterface::class, $object->ipv6Pools);
        self::assertInstanceOf(IPv6RangeRepositoryInterface::class, $object->ipv6Ranges);
        self::assertInstanceOf(NodeBalancerRepositoryInterface::class, $object->nodeBalancers);
        self::assertInstanceOf(ObjectStorageClusterRepositoryInterface::class, $object->objectStorageClusters);
        self::assertInstanceOf(ObjectStorageKeyRepositoryInterface::class, $object->objectStorageKeys);
        self::assertInstanceOf(RegionRepositoryInterface::class, $object->regions);
        self::assertInstanceOf(StackScriptRepositoryInterface::class, $object->stackScripts);
        self::assertInstanceOf(SupportTicketRepositoryInterface::class, $object->supportTickets);
        self::assertInstanceOf(TagRepositoryInterface::class, $object->tags);
        self::assertInstanceOf(VlansRepositoryInterface::class, $object->vlans);
        self::assertInstanceOf(VolumeRepositoryInterface::class, $object->volumes);

        self::assertNull($object->unknown);
    }

    /**
     * @covers ::get
     */
    public function testGetAnonymous(): void
    {
        $client = new class() extends Client {
            public function request($method, $uri = '', array $options = []): Response
            {
                return new Response(200, [], json_encode($options));
            }
        };

        $object = new LinodeClient();
        $this->setProperty($object, 'client', $client);

        $response = $object->get('/test');
        self::assertSame([], json_decode($response->getBody()->getContents(), true));

        $response = $object->get('/test', ['page' => 2, 'page_size' => 25]);
        self::assertSame([
            'query' => [
                'page'      => 2,
                'page_size' => 25,
            ],
        ], json_decode($response->getBody()->getContents(), true));

        $response = $object->get('/test', [], ['class' => 'standard', 'vcpus' => 1]);
        self::assertSame([
            'headers' => [
                'X-Filter' => '{"class":"standard","vcpus":1}',
            ],
        ], json_decode($response->getBody()->getContents(), true));

        $response = $object->get('/test', ['page' => 2, 'page_size' => 25], ['class' => 'standard', 'vcpus' => 1]);
        self::assertSame([
            'headers' => [
                'X-Filter' => '{"class":"standard","vcpus":1}',
            ],
            'query' => [
                'page'      => 2,
                'page_size' => 25,
            ],
        ], json_decode($response->getBody()->getContents(), true));
    }

    /**
     * @covers ::get
     */
    public function testGet(): void
    {
        $client = new class() extends Client {
            public function request($method, $uri = '', array $options = []): Response
            {
                return new Response(200, [], json_encode($options));
            }
        };

        $object = new LinodeClient('secret');
        $this->setProperty($object, 'client', $client);

        $response = $object->get('/test');
        self::assertSame([
            'headers' => [
                'Authorization' => 'Bearer secret',
            ],
        ], json_decode($response->getBody()->getContents(), true));

        $response = $object->get('/test', ['page' => 2, 'page_size' => 25]);
        self::assertSame([
            'query' => [
                'page'      => 2,
                'page_size' => 25,
            ],
            'headers' => [
                'Authorization' => 'Bearer secret',
            ],
        ], json_decode($response->getBody()->getContents(), true));

        $response = $object->get('/test', [], ['class' => 'standard', 'vcpus' => 1]);
        self::assertSame([
            'headers' => [
                'X-Filter'      => '{"class":"standard","vcpus":1}',
                'Authorization' => 'Bearer secret',
            ],
        ], json_decode($response->getBody()->getContents(), true));

        $response = $object->get('/test', ['page' => 2, 'page_size' => 25], ['class' => 'standard', 'vcpus' => 1]);
        self::assertSame([
            'headers' => [
                'X-Filter'      => '{"class":"standard","vcpus":1}',
                'Authorization' => 'Bearer secret',
            ],
            'query' => [
                'page'      => 2,
                'page_size' => 25,
            ],
        ], json_decode($response->getBody()->getContents(), true));
    }

    /**
     * @covers ::post
     */
    public function testPost(): void
    {
        $client = new class() extends Client {
            public function request($method, $uri = '', array $options = []): Response
            {
                return new Response(200, [], json_encode($options));
            }
        };

        $object = new LinodeClient('secret');
        $this->setProperty($object, 'client', $client);

        $response = $object->post('/test');
        self::assertSame([
            'headers' => [
                'Authorization' => 'Bearer secret',
            ],
        ], json_decode($response->getBody()->getContents(), true));

        $response = $object->post('/test', ['domain' => 'example.com', 'type' => 'master']);
        self::assertSame([
            'json' => [
                'domain' => 'example.com',
                'type'   => 'master',
            ],
            'headers' => [
                'Authorization' => 'Bearer secret',
            ],
        ], json_decode($response->getBody()->getContents(), true));
    }

    /**
     * @covers ::put
     */
    public function testPut(): void
    {
        $client = new class() extends Client {
            public function request($method, $uri = '', array $options = []): Response
            {
                return new Response(200, [], json_encode($options));
            }
        };

        $object = new LinodeClient('secret');
        $this->setProperty($object, 'client', $client);

        $response = $object->put('/test');
        self::assertSame([
            'headers' => [
                'Authorization' => 'Bearer secret',
            ],
        ], json_decode($response->getBody()->getContents(), true));

        $response = $object->put('/test', ['domain' => 'example.com', 'type' => 'master']);
        self::assertSame([
            'json' => [
                'domain' => 'example.com',
                'type'   => 'master',
            ],
            'headers' => [
                'Authorization' => 'Bearer secret',
            ],
        ], json_decode($response->getBody()->getContents(), true));
    }

    /**
     * @covers ::delete
     */
    public function testDelete(): void
    {
        $client = new class() extends Client {
            public function request($method, $uri = '', array $options = []): Response
            {
                return new Response(200, [], json_encode($options));
            }
        };

        $object = new LinodeClient('secret');
        $this->setProperty($object, 'client', $client);

        $response = $object->delete('/test');
        self::assertSame([
            'headers' => [
                'Authorization' => 'Bearer secret',
            ],
        ], json_decode($response->getBody()->getContents(), true));
    }

    /**
     * @covers ::api
     */
    public function testApiClientException(): void
    {
        $this->expectException(LinodeException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Unknown error');

        $client = new class() extends Client {
            public function request($method, $uri = '', array $options = []): ResponseInterface
            {
                $request  = new Request($method, $uri);
                $response = new Response(400);

                throw new ClientException('Invalid URI', $request, $response);
            }
        };

        $object = new LinodeClient('secret');
        $this->setProperty($object, 'client', $client);

        $object->get('/test');
    }

    /**
     * @covers ::api
     */
    public function testApiGuzzleException(): void
    {
        $this->expectException(LinodeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Unknown error');

        $client = new class() extends Client {
            public function request($method, $uri = '', array $options = []): ResponseInterface
            {
                throw new TransferException('Invalid URI');
            }
        };

        $object = new LinodeClient('secret');
        $this->setProperty($object, 'client', $client);

        $object->get('/test');
    }
}
