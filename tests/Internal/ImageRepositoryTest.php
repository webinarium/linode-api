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
use GuzzleHttp\Psr7\Response;
use Linode\Entity\Image;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\ImageRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\ImageRepository
 */
final class ImageRepositoryTest extends TestCase
{
    use ReflectionTrait;

    protected ImageRepositoryInterface $repository;

    protected function setUp(): void
    {
        $client = new LinodeClient();

        $this->repository = new ImageRepository($client);
    }

    public function testCreate(): void
    {
        $request = [
            'json' => [
                'label'       => 'My gold-master image',
                'description' => 'The detailed description of my Image.',
                'disk_id'     => 42,
            ],
        ];

        $response = <<<'JSON'
                        {
                            "id": "private/67848373",
                            "label": "My gold-master image",
                            "created": "2018-01-01T00:01:01",
                            "created_by": "somename",
                            "deprecated": false,
                            "description": "The detailed description of my Image.",
                            "is_public": false,
                            "size": 2500,
                            "type": "manual",
                            "expiry": "2018-08-01T00:01:01",
                            "vendor": null
                        }
            JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/images', $request, new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $entity = $repository->create([
            Image::FIELD_LABEL       => 'My gold-master image',
            Image::FIELD_DESCRIPTION => 'The detailed description of my Image.',
            Image::FIELD_DISK_ID     => 42,
        ]);

        self::assertInstanceOf(Image::class, $entity);
        self::assertSame('private/67848373', $entity->id);
        self::assertSame('My gold-master image', $entity->label);
    }

    public function testUpdate(): void
    {
        $request = [
            'json' => [
                'label'       => 'My gold-master image',
                'description' => 'The detailed description of my Image.',
            ],
        ];

        $response = <<<'JSON'
                        {
                            "id": "private/67848373",
                            "label": "My gold-master image",
                            "created": "2018-01-01T00:01:01",
                            "created_by": "somename",
                            "deprecated": false,
                            "description": "The detailed description of my Image.",
                            "is_public": false,
                            "size": 2500,
                            "type": "manual",
                            "expiry": "2018-08-01T00:01:01",
                            "vendor": null
                        }
            JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['PUT', 'https://api.linode.com/v4/images/private/67848373', $request, new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $entity = $repository->update('private/67848373', [
            Image::FIELD_LABEL       => 'My gold-master image',
            Image::FIELD_DESCRIPTION => 'The detailed description of my Image.',
        ]);

        self::assertInstanceOf(Image::class, $entity);
        self::assertSame('private/67848373', $entity->id);
        self::assertSame('My gold-master image', $entity->label);
    }

    public function testDelete(): void
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['DELETE', 'https://api.linode.com/v4/images/private/67848373', [], new Response(200, [], null)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $repository->delete('private/67848373');

        self::assertTrue(true);
    }

    public function testGetBaseUri(): void
    {
        $expected = '/images';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields(): void
    {
        $expected = [
            'id',
            'label',
            'vendor',
            'description',
            'is_public',
            'size',
            'type',
            'deprecated',
            'disk_id',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity(): void
    {
        self::assertInstanceOf(Image::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): ImageRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new ImageRepository($linodeClient);
    }
}
