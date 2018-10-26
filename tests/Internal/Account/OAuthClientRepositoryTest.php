<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal\Account;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Linode\Entity\Account\OAuthClient;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Account\OAuthClientRepositoryInterface;
use PHPUnit\Framework\TestCase;

class OAuthClientRepositoryTest extends TestCase
{
    use ReflectionTrait;

    /** @var OAuthClientRepository */
    protected $repository;

    protected function setUp()
    {
        $client = new LinodeClient();

        $this->repository = new OAuthClientRepository($client);
    }

    public function testCreate()
    {
        $request = [
            'json' => [
                'label'        => 'Test_Client_1',
                'redirect_uri' => 'https://example.org/oauth/callback',
            ],
        ];

        $response = <<<'JSON'
            {
                "id": "2737bf16b39ab5d7b4a1",
                "redirect_uri": "https://example.org/oauth/callback",
                "label": "Test_Client_1",
                "status": "active",
                "secret": "dcabee56a15346f6bf04e3a05d3fda98",
                "thumbnail_url": "https://api.linode.com/v4/account/clients/2737bf16b39ab5d7b4a1/thumbnail",
                "public": false
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/account/oauth-clients', $request, new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->create([
            OAuthClient::FIELD_LABEL        => 'Test_Client_1',
            OAuthClient::FIELD_REDIRECT_URI => 'https://example.org/oauth/callback',
        ]);

        self::assertInstanceOf(OAuthClient::class, $entity);
        self::assertSame('2737bf16b39ab5d7b4a1', $entity->id);
        self::assertSame('Test_Client_1', $entity->label);
        self::assertSame('dcabee56a15346f6bf04e3a05d3fda98', $entity->secret);
    }

    public function testUpdate()
    {
        $request = [
            'json' => [
                'label'        => 'Test_Client_1',
                'redirect_uri' => 'https://example.org/oauth/callback',
            ],
        ];

        $response = <<<'JSON'
            {
                "id": "2737bf16b39ab5d7b4a1",
                "redirect_uri": "https://example.org/oauth/callback",
                "label": "Test_Client_1",
                "status": "active",
                "secret": "<REDACTED>",
                "thumbnail_url": "https://api.linode.com/v4/account/clients/2737bf16b39ab5d7b4a1/thumbnail",
                "public": false
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['PUT', 'https://api.linode.com/v4/account/oauth-clients/2737bf16b39ab5d7b4a1', $request, new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->update('2737bf16b39ab5d7b4a1', [
            OAuthClient::FIELD_LABEL        => 'Test_Client_1',
            OAuthClient::FIELD_REDIRECT_URI => 'https://example.org/oauth/callback',
        ]);

        self::assertInstanceOf(OAuthClient::class, $entity);
        self::assertSame('2737bf16b39ab5d7b4a1', $entity->id);
        self::assertSame('Test_Client_1', $entity->label);
        self::assertSame('<REDACTED>', $entity->secret);
    }

    public function testDelete()
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['DELETE', 'https://api.linode.com/v4/account/oauth-clients/2737bf16b39ab5d7b4a1', [], new Response(200, [], null)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $repository->delete('2737bf16b39ab5d7b4a1');

        self::assertTrue(true);
    }

    public function testResetSecret()
    {
        $response = <<<'JSON'
            {
                "id": "2737bf16b39ab5d7b4a1",
                "redirect_uri": "https://example.org/oauth/callback",
                "label": "Test_Client_1",
                "status": "active",
                "secret": "dcabee56a15346f6bf04e3a05d3fda98",
                "thumbnail_url": "https://api.linode.com/v4/account/clients/2737bf16b39ab5d7b4a1/thumbnail",
                "public": false
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/account/oauth-clients/2737bf16b39ab5d7b4a1/reset-secret', [], new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->resetSecret('2737bf16b39ab5d7b4a1');

        self::assertInstanceOf(OAuthClient::class, $entity);
        self::assertSame('2737bf16b39ab5d7b4a1', $entity->id);
        self::assertSame('Test_Client_1', $entity->label);
        self::assertSame('dcabee56a15346f6bf04e3a05d3fda98', $entity->secret);
    }

    public function testGetBaseUri()
    {
        $expected = '/account/oauth-clients';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields()
    {
        $expected = [
            'id',
            'label',
            'status',
            'public',
            'redirect_uri',
            'secret',
            'thumbnail_url',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity()
    {
        self::assertInstanceOf(OAuthClient::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): OAuthClientRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new OAuthClientRepository($linodeClient);
    }
}
