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
use Linode\Entity\Managed\ManagedContact;
use Linode\Entity\Managed\Phone;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Managed\ManagedContactRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\Managed\ManagedContactRepository
 */
final class ManagedContactRepositoryTest extends TestCase
{
    use ReflectionTrait;

    protected ManagedContactRepositoryInterface $repository;

    protected function setUp(): void
    {
        $client = new LinodeClient();

        $this->repository = new ManagedContactRepository($client);
    }

    public function testCreate(): void
    {
        $request = [
            'json' => [
                'name'  => 'John Doe',
                'email' => 'john.doe@example.org',
                'phone' => [
                    'primary'   => '123-456-7890',
                    'secondary' => null,
                ],
                'group' => 'on-call',
            ],
        ];

        $response = <<<'JSON'
                        {
                            "id": 567,
                            "name": "John Doe",
                            "email": "john.doe@example.org",
                            "phone": {
                                "primary": "123-456-7890",
                                "secondary": null
                            },
                            "group": "on-call",
                            "updated": "2018-01-01T00:01:01"
                        }
            JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/managed/contacts', $request, new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $entity = $repository->create([
            ManagedContact::FIELD_NAME  => 'John Doe',
            ManagedContact::FIELD_EMAIL => 'john.doe@example.org',
            ManagedContact::FIELD_PHONE => [
                Phone::FIELD_PRIMARY   => '123-456-7890',
                Phone::FIELD_SECONDARY => null,
            ],
            ManagedContact::FIELD_GROUP => 'on-call',
        ]);

        self::assertInstanceOf(ManagedContact::class, $entity);
        self::assertSame(567, $entity->id);
        self::assertSame('John Doe', $entity->name);
    }

    public function testUpdate(): void
    {
        $request = [
            'json' => [
                'name'  => 'John Doe',
                'email' => 'john.doe@example.org',
                'phone' => [
                    'primary'   => '123-456-7890',
                    'secondary' => null,
                ],
                'group' => 'on-call',
            ],
        ];

        $response = <<<'JSON'
                        {
                            "id": 567,
                            "name": "John Doe",
                            "email": "john.doe@example.org",
                            "phone": {
                                "primary": "123-456-7890",
                                "secondary": null
                            },
                            "group": "on-call",
                            "updated": "2018-01-01T00:01:01"
                        }
            JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['PUT', 'https://api.linode.com/v4/managed/contacts/567', $request, new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $entity = $repository->update(567, [
            ManagedContact::FIELD_NAME  => 'John Doe',
            ManagedContact::FIELD_EMAIL => 'john.doe@example.org',
            ManagedContact::FIELD_PHONE => [
                Phone::FIELD_PRIMARY   => '123-456-7890',
                Phone::FIELD_SECONDARY => null,
            ],
            ManagedContact::FIELD_GROUP => 'on-call',
        ]);

        self::assertInstanceOf(ManagedContact::class, $entity);
        self::assertSame(567, $entity->id);
        self::assertSame('John Doe', $entity->name);
    }

    public function testDelete(): void
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['DELETE', 'https://api.linode.com/v4/managed/contacts/567', [], new Response(200, [], null)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $repository->delete(567);

        self::assertTrue(true);
    }

    public function testGetBaseUri(): void
    {
        $expected = '/managed/contacts';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields(): void
    {
        $expected = [
            'id',
            'name',
            'email',
            'phone',
            'group',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity(): void
    {
        self::assertInstanceOf(ManagedContact::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): ManagedContactRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new ManagedContactRepository($linodeClient);
    }
}
