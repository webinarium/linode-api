<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal\Support;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Linode\Entity\Support\SupportTicketReply;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Support\SupportTicketReplyRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\Support\SupportTicketReplyRepository
 */
final class SupportTicketReplyRepositoryTest extends TestCase
{
    use ReflectionTrait;

    protected SupportTicketReplyRepositoryInterface $repository;

    protected function setUp(): void
    {
        $client = new LinodeClient();

        $this->repository = new SupportTicketReplyRepository($client, 11223344);
    }

    public function testCreate(): void
    {
        $request = [
            'json' => [
                'description' => 'Thank you for your help. I was able to figure out what the problem was and I successfully reset my password. You guys are the best!',
            ],
        ];

        $response = <<<'JSON'
                        {
                            "created": "2015-06-02T14:31:41",
                            "created_by": "John Q. Linode",
                            "description": "Thank you for your help. I was able to figure out what the problem was and I successfully reset my password. You guys are the best!",
                            "from_linode": true,
                            "gravatar_id": "474a1b7373ae0be4132649e69c36ce30",
                            "id": 11223345
                        }
            JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/support/tickets/11223344/replies', $request, new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $entity = $repository->create([
            SupportTicketReply::FIELD_DESCRIPTION => 'Thank you for your help. I was able to figure out what the problem was and I successfully reset my password. You guys are the best!',
        ]);

        self::assertInstanceOf(SupportTicketReply::class, $entity);
        self::assertSame(11223345, $entity->id);
        self::assertSame('John Q. Linode', $entity->created_by);
    }

    public function testGetBaseUri(): void
    {
        $expected = '/support/tickets/11223344/replies';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields(): void
    {
        $expected = [
            'id',
            'created_by',
            'created',
            'description',
            'gravatar_id',
            'from_linode',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity(): void
    {
        self::assertInstanceOf(SupportTicketReply::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): SupportTicketReplyRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new SupportTicketReplyRepository($linodeClient, 11223344);
    }
}
