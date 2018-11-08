<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal\Profile;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Linode\Entity\Profile\SSHKey;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Profile\SSHKeyRepositoryInterface;
use PHPUnit\Framework\TestCase;

class SSHKeyRepositoryTest extends TestCase
{
    use ReflectionTrait;

    /** @var SSHKeyRepository */
    protected $repository;

    protected function setUp()
    {
        $client = new LinodeClient();

        $this->repository = new SSHKeyRepository($client);
    }

    public function testAdd()
    {
        $request = [
            'json' => [
                'label'   => 'My SSH Key',
                'ssh_key' => 'string',
            ],
        ];

        $response = <<<'JSON'
            {
                "id": 42,
                "label": "My SSH Key",
                "ssh_key": "string",
                "created": "2018-01-01T00:01:01"
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/profile/sshkeys', $request, new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->add([
            SSHKey::FIELD_LABEL   => 'My SSH Key',
            SSHKey::FIELD_SSH_KEY => 'string',
        ]);

        self::assertInstanceOf(SSHKey::class, $entity);
        self::assertSame(42, $entity->id);
        self::assertSame('My SSH Key', $entity->label);
    }

    public function testUpdate()
    {
        $request = [
            'json' => [
                'label' => 'My SSH Key',
            ],
        ];

        $response = <<<'JSON'
            {
                "id": 42,
                "label": "My SSH Key",
                "ssh_key": "string",
                "created": "2018-01-01T00:01:01"
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['PUT', 'https://api.linode.com/v4/profile/sshkeys/42', $request, new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->update(42, [
            SSHKey::FIELD_LABEL => 'My SSH Key',
        ]);

        self::assertInstanceOf(SSHKey::class, $entity);
        self::assertSame(42, $entity->id);
        self::assertSame('My SSH Key', $entity->label);
    }

    public function testDelete()
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['DELETE', 'https://api.linode.com/v4/profile/sshkeys/42', [], new Response(200, [], null)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $repository->delete(42);

        self::assertTrue(true);
    }

    public function testGetBaseUri()
    {
        $expected = '/profile/sshkeys';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields()
    {
        $expected = [
            'id',
            'label',
            'ssh_key',
            'created',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity()
    {
        self::assertInstanceOf(SSHKey::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): SSHKeyRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new SSHKeyRepository($linodeClient);
    }
}
