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
use Linode\Exception\LinodeException;
use Linode\Regions\RegionRepositoryInterface;
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

        self::assertInstanceOf(RegionRepositoryInterface::class, $object->regions);

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
