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
use Linode\Entity\Profile\PersonalAccessToken;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Profile\PersonalAccessTokenRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\Profile\PersonalAccessTokenRepository
 */
final class PersonalAccessTokenRepositoryTest extends TestCase
{
    use ReflectionTrait;

    protected PersonalAccessTokenRepositoryInterface $repository;

    protected function setUp(): void
    {
        $client = new LinodeClient();

        $this->repository = new PersonalAccessTokenRepository($client);
    }

    public function testCreate(): void
    {
        $request = [
            'json' => [
                'scopes' => '*',
                'expiry' => null,
                'label'  => 'linode-cli',
            ],
        ];

        $response = <<<'JSON'
                        {
                            "id": 123,
                            "scopes": "*",
                            "created": "2018-01-01T00:01:01.000Z",
                            "label": "linode-cli",
                            "token": "abcdefghijklmnop",
                            "expiry": "2018-01-01T13:46:32"
                        }
            JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/profile/tokens', $request, new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $entity = $repository->create([
            PersonalAccessToken::FIELD_SCOPES => '*',
            PersonalAccessToken::FIELD_EXPIRY => null,
            PersonalAccessToken::FIELD_LABEL  => 'linode-cli',
        ]);

        self::assertInstanceOf(PersonalAccessToken::class, $entity);
        self::assertSame(123, $entity->id);
        self::assertSame('linode-cli', $entity->label);
    }

    public function testUpdate(): void
    {
        $request = [
            'json' => [
                'label' => 'linode-cli',
            ],
        ];

        $response = <<<'JSON'
                        {
                            "id": 123,
                            "scopes": "*",
                            "created": "2018-01-01T00:01:01.000Z",
                            "label": "linode-cli",
                            "token": "abcdefghijklmnop",
                            "expiry": "2018-01-01T13:46:32"
                        }
            JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['PUT', 'https://api.linode.com/v4/profile/tokens/123', $request, new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $entity = $repository->update(123, [
            PersonalAccessToken::FIELD_LABEL => 'linode-cli',
        ]);

        self::assertInstanceOf(PersonalAccessToken::class, $entity);
        self::assertSame(123, $entity->id);
        self::assertSame('linode-cli', $entity->label);
    }

    public function testRevoke(): void
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['DELETE', 'https://api.linode.com/v4/profile/tokens/123', [], new Response(200, [], null)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $repository->revoke(123);

        self::assertTrue(true);
    }

    public function testGetBaseUri(): void
    {
        $expected = '/profile/tokens';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields(): void
    {
        $expected = [
            'id',
            'label',
            'scopes',
            'created',
            'token',
            'expiry',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity(): void
    {
        self::assertInstanceOf(PersonalAccessToken::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): PersonalAccessTokenRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new PersonalAccessTokenRepository($linodeClient);
    }
}
