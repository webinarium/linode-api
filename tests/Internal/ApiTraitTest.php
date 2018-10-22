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
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Linode\Exception\LinodeException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class ApiTraitTest extends TestCase
{
    public function testApiGetAnonymous()
    {
        $client = new class() extends Client {
            public function request($method, $uri = '', array $options = [])
            {
                return new Response(200, [], json_encode($options));
            }
        };

        $object = $this->mockApiTrait($client);

        /** @var ResponseInterface $response */
        $response = $object->proxyApi('GET', '/test');
        self::assertSame([], json_decode($response->getBody()->getContents(), true));

        /** @var ResponseInterface $response */
        $response = $object->proxyApi('GET', '/test', ['page' => 2, 'page_size' => 25]);
        self::assertSame([
            'query' => [
                'page'      => 2,
                'page_size' => 25,
            ],
        ], json_decode($response->getBody()->getContents(), true));

        /** @var ResponseInterface $response */
        $response = $object->proxyApi('GET', '/test', [], ['class' => 'standard', 'vcpus' => 1]);
        self::assertSame([
            'headers' => [
                'X-Filter' => '{"class":"standard","vcpus":1}',
            ],
        ], json_decode($response->getBody()->getContents(), true));

        /** @var ResponseInterface $response */
        $response = $object->proxyApi('GET', '/test', ['page' => 2, 'page_size' => 25], ['class' => 'standard', 'vcpus' => 1]);
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

    public function testApiGet()
    {
        $client = new class() extends Client {
            public function request($method, $uri = '', array $options = [])
            {
                return new Response(200, [], json_encode($options));
            }
        };

        $object = $this->mockApiTrait($client, 'secret');

        /** @var ResponseInterface $response */
        $response = $object->proxyApi('GET', '/test');
        self::assertSame([
            'headers' => [
                'Authorization' => 'Bearer secret',
            ],
        ], json_decode($response->getBody()->getContents(), true));

        /** @var ResponseInterface $response */
        $response = $object->proxyApi('GET', '/test', ['page' => 2, 'page_size' => 25]);
        self::assertSame([
            'headers' => [
                'Authorization' => 'Bearer secret',
            ],
            'query' => [
                'page'      => 2,
                'page_size' => 25,
            ],
        ], json_decode($response->getBody()->getContents(), true));

        /** @var ResponseInterface $response */
        $response = $object->proxyApi('GET', '/test', [], ['class' => 'standard', 'vcpus' => 1]);
        self::assertSame([
            'headers' => [
                'Authorization' => 'Bearer secret',
                'X-Filter'      => '{"class":"standard","vcpus":1}',
            ],
        ], json_decode($response->getBody()->getContents(), true));

        /** @var ResponseInterface $response */
        $response = $object->proxyApi('GET', '/test', ['page' => 2, 'page_size' => 25], ['class' => 'standard', 'vcpus' => 1]);
        self::assertSame([
            'headers' => [
                'Authorization' => 'Bearer secret',
                'X-Filter'      => '{"class":"standard","vcpus":1}',
            ],
            'query' => [
                'page'      => 2,
                'page_size' => 25,
            ],
        ], json_decode($response->getBody()->getContents(), true));
    }

    public function testApiPost()
    {
        $client = new class() extends Client {
            public function request($method, $uri = '', array $options = [])
            {
                return new Response(200, [], json_encode($options));
            }
        };

        $object = $this->mockApiTrait($client, 'secret');

        /** @var ResponseInterface $response */
        $response = $object->proxyApi('POST', '/test');
        self::assertSame([
            'headers' => [
                'Authorization' => 'Bearer secret',
            ],
        ], json_decode($response->getBody()->getContents(), true));

        /** @var ResponseInterface $response */
        $response = $object->proxyApi('POST', '/test', ['domain' => 'example.com', 'type' => 'master']);
        self::assertSame([
            'headers' => [
                'Authorization' => 'Bearer secret',
            ],
            'json' => [
                'domain' => 'example.com',
                'type'   => 'master',
            ],
        ], json_decode($response->getBody()->getContents(), true));

        /** @var ResponseInterface $response */
        $response = $object->proxyApi('POST', '/test', [], ['class' => 'standard', 'vcpus' => 1]);
        self::assertSame([
            'headers' => [
                'Authorization' => 'Bearer secret',
            ],
        ], json_decode($response->getBody()->getContents(), true));

        /** @var ResponseInterface $response */
        $response = $object->proxyApi('POST', '/test', ['domain' => 'example.com', 'type' => 'master'], ['class' => 'standard', 'vcpus' => 1]);
        self::assertSame([
            'headers' => [
                'Authorization' => 'Bearer secret',
            ],
            'json' => [
                'domain' => 'example.com',
                'type'   => 'master',
            ],
        ], json_decode($response->getBody()->getContents(), true));
    }

    public function testApiPut()
    {
        $client = new class() extends Client {
            public function request($method, $uri = '', array $options = [])
            {
                return new Response(200, [], json_encode($options));
            }
        };

        $object = $this->mockApiTrait($client, 'secret');

        /** @var ResponseInterface $response */
        $response = $object->proxyApi('PUT', '/test');
        self::assertSame([
            'headers' => [
                'Authorization' => 'Bearer secret',
            ],
        ], json_decode($response->getBody()->getContents(), true));

        /** @var ResponseInterface $response */
        $response = $object->proxyApi('PUT', '/test', ['domain' => 'example.com', 'type' => 'master']);
        self::assertSame([
            'headers' => [
                'Authorization' => 'Bearer secret',
            ],
            'json' => [
                'domain' => 'example.com',
                'type'   => 'master',
            ],
        ], json_decode($response->getBody()->getContents(), true));

        /** @var ResponseInterface $response */
        $response = $object->proxyApi('PUT', '/test', [], ['class' => 'standard', 'vcpus' => 1]);
        self::assertSame([
            'headers' => [
                'Authorization' => 'Bearer secret',
            ],
        ], json_decode($response->getBody()->getContents(), true));

        /** @var ResponseInterface $response */
        $response = $object->proxyApi('PUT', '/test', ['domain' => 'example.com', 'type' => 'master'], ['class' => 'standard', 'vcpus' => 1]);
        self::assertSame([
            'headers' => [
                'Authorization' => 'Bearer secret',
            ],
            'json' => [
                'domain' => 'example.com',
                'type'   => 'master',
            ],
        ], json_decode($response->getBody()->getContents(), true));
    }

    public function testApiDelete()
    {
        $client = new class() extends Client {
            public function request($method, $uri = '', array $options = [])
            {
                return new Response(200, [], json_encode($options));
            }
        };

        $object = $this->mockApiTrait($client, 'secret');

        /** @var ResponseInterface $response */
        $response = $object->proxyApi('DELETE', '/test');
        self::assertSame([
            'headers' => [
                'Authorization' => 'Bearer secret',
            ],
        ], json_decode($response->getBody()->getContents(), true));

        /** @var ResponseInterface $response */
        $response = $object->proxyApi('DELETE', '/test', ['domain' => 'example.com', 'type' => 'master']);
        self::assertSame([
            'headers' => [
                'Authorization' => 'Bearer secret',
            ],
        ], json_decode($response->getBody()->getContents(), true));

        /** @var ResponseInterface $response */
        $response = $object->proxyApi('DELETE', '/test', [], ['class' => 'standard', 'vcpus' => 1]);
        self::assertSame([
            'headers' => [
                'Authorization' => 'Bearer secret',
            ],
        ], json_decode($response->getBody()->getContents(), true));

        /** @var ResponseInterface $response */
        $response = $object->proxyApi('DELETE', '/test', ['domain' => 'example.com', 'type' => 'master'], ['class' => 'standard', 'vcpus' => 1]);
        self::assertSame([
            'headers' => [
                'Authorization' => 'Bearer secret',
            ],
        ], json_decode($response->getBody()->getContents(), true));
    }

    public function testApiClientException()
    {
        $this->expectException(LinodeException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Unknown error');

        $client = new class() extends Client {
            public function request($method, $uri = '', array $options = [])
            {
                $request  = new Request($method, $uri);
                $response = new Response(400);

                throw new ClientException('Invalid URI', $request, $response);
            }
        };

        $object = $this->mockApiTrait($client, 'secret');

        $object->proxyApi('GET', '/client');
    }

    public function testApiGuzzleException()
    {
        $this->expectException(LinodeException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Unknown error');

        $client = new class() extends Client {
            public function request($method, $uri = '', array $options = [])
            {
                throw new TransferException('Invalid URI');
            }
        };

        $object = $this->mockApiTrait($client, 'secret');

        $object->proxyApi('GET', '/guzzle');
    }

    protected function mockApiTrait(Client $client, string $access_token = null)
    {
        return new class($client, $access_token) {
            use ApiTrait;

            public function __construct(Client $client, string $access_token = null)
            {
                $this->client       = $client;
                $this->base_uri     = 'http://localhost';
                $this->access_token = $access_token;
            }

            public function proxyApi(string $method, string $uri, array $parameters = [], array $filters = []): ResponseInterface
            {
                return $this->api($method, $uri, $parameters, $filters);
            }
        };
    }
}
