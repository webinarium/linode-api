<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal\Tags;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Linode\Entity\Tag;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Tags\TagRepositoryInterface;
use PHPUnit\Framework\TestCase;

class TagRepositoryTest extends TestCase
{
    use ReflectionTrait;

    /** @var TagRepository */
    protected $repository;

    protected function setUp()
    {
        $client = new LinodeClient();

        $this->repository = new TagRepository($client);
    }

    public function testCreate()
    {
        $request = [
            'json' => [
                'label' => 'example tag',
            ],
        ];

        $response = <<<'JSON'
            {
                "label": "example tag"
            }
JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/tags', $request, new Response(200, [], $response)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $repository->create([
            Tag::FIELD_LABEL => 'example tag',
        ]);

        self::assertInstanceOf(Tag::class, $entity);
        self::assertSame('example tag', $entity->label);
    }

    public function testDelete()
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['DELETE', 'https://api.linode.com/v4/tags/example tag', [], new Response(200, [], null)],
            ]);

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $repository->delete('example tag');

        self::assertTrue(true);
    }

    public function testGetBaseUri()
    {
        $expected = '/tags';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields()
    {
        $expected = [
            'label',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity()
    {
        self::assertInstanceOf(Tag::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): TagRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new TagRepository($linodeClient);
    }
}
