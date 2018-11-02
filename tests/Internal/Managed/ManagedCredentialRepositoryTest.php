<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal\Managed;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Linode\Entity\Managed\ManagedCredential;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Managed\ManagedCredentialRepositoryInterface;
use PHPUnit\Framework\TestCase;

class ManagedCredentialRepositoryTest extends TestCase
{
    use ReflectionTrait;

    /** @var ManagedCredentialRepository */
    protected $repository;

    protected function setUp()
    {
        $client = new LinodeClient();

        $this->repository = new ManagedCredentialRepository($client);
    }

    public function testCreate()
    {
        $request = [
            'json' => [
                'label'    => 'prod-password-1',
                'username' => 'johndoe',
                'password' => 's3cur3P@ssw0rd',
            ],
        ];

        $response = <<<'JSON'
            {
                "id": 9991,
                "label": "prod-password-1"
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/managed/credentials', $request, new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->create([
            ManagedCredential::FIELD_LABEL    => 'prod-password-1',
            ManagedCredential::FIELD_USERNAME => 'johndoe',
            ManagedCredential::FIELD_PASSWORD => 's3cur3P@ssw0rd',
        ]);

        self::assertInstanceOf(ManagedCredential::class, $entity);
        self::assertSame(9991, $entity->id);
        self::assertSame('prod-password-1', $entity->label);
    }

    public function testUpdate()
    {
        $request = [
            'json' => [
                'label' => 'prod-password-1',
            ],
        ];

        $response = <<<'JSON'
            {
                "id": 9991,
                "label": "prod-password-1"
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['PUT', 'https://api.linode.com/v4/managed/credentials/9991', $request, new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->update(9991, [
            ManagedCredential::FIELD_LABEL => 'prod-password-1',
        ]);

        self::assertInstanceOf(ManagedCredential::class, $entity);
        self::assertSame(9991, $entity->id);
        self::assertSame('prod-password-1', $entity->label);
    }

    public function testDelete()
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/managed/credentials/9991/revoke', [], new Response(200, [], null)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $repository->delete(9991);

        self::assertTrue(true);
    }

    public function testGetBaseUri()
    {
        $expected = '/managed/credentials';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields()
    {
        $expected = [
            'id',
            'label',
            'username',
            'password',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity()
    {
        self::assertInstanceOf(ManagedCredential::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): ManagedCredentialRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new ManagedCredentialRepository($linodeClient);
    }
}
