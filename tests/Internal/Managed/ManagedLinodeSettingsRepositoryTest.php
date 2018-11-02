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
use Linode\Entity\Managed\ManagedLinodeSettings;
use Linode\Entity\Managed\SSHSettings;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Managed\ManagedLinodeSettingsRepositoryInterface;
use PHPUnit\Framework\TestCase;

class ManagedLinodeSettingsRepositoryTest extends TestCase
{
    use ReflectionTrait;

    /** @var ManagedLinodeSettingsRepository */
    protected $repository;

    protected function setUp()
    {
        $client = new LinodeClient();

        $this->repository = new ManagedLinodeSettingsRepository($client);
    }

    public function testUpdate()
    {
        $request = [
            'json' => [
                'ssh' => [
                    'access' => true,
                    'user'   => 'linode',
                    'ip'     => '12.34.56.78',
                    'port'   => 22,
                ],
            ],
        ];

        $response = <<<'JSON'
            {
                "id": 123,
                "label": "linode123",
                "group": "linodes",
                "ssh": {
                    "access": true,
                    "user": "linode",
                    "ip": "12.34.56.78",
                    "port": 22
                }
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['PUT', 'https://api.linode.com/v4/managed/linode-settings/123', $request, new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->update(123, [
            ManagedLinodeSettings::FIELD_SSH => [
                SSHSettings::FIELD_ACCESS => true,
                SSHSettings::FIELD_USER   => 'linode',
                SSHSettings::FIELD_IP     => '12.34.56.78',
                SSHSettings::FIELD_PORT   => 22,
            ],
        ]);

        self::assertInstanceOf(ManagedLinodeSettings::class, $entity);
        self::assertSame(123, $entity->id);
        self::assertSame('linode123', $entity->label);
    }

    public function testGetBaseUri()
    {
        $expected = '/managed/linode-settings';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields()
    {
        $expected = [
            'id',
            'label',
            'group',
            'ssh',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity()
    {
        self::assertInstanceOf(ManagedLinodeSettings::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): ManagedLinodeSettingsRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new ManagedLinodeSettingsRepository($linodeClient);
    }
}
