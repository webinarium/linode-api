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
use Linode\Entity\Support\SupportTicket;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Support\SupportTicketRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\Support\SupportTicketRepository
 */
final class SupportTicketRepositoryTest extends TestCase
{
    use ReflectionTrait;

    protected SupportTicketRepositoryInterface $repository;

    protected function setUp(): void
    {
        $client = new LinodeClient();

        $this->repository = new SupportTicketRepository($client);
    }

    public function testOpen(): void
    {
        $request = [
            'json' => [
                'description'       => 'I\'m having trouble setting the root password on my Linode. I tried following the instructions but something is not working and I\'m not sure what I\'m doing wrong. Can you please help me figure out how I can reset it?',
                'domain_id'         => null,
                'linode_id'         => 123,
                'longviewclient_id' => null,
                'nodebalancer_id'   => null,
                'summary'           => 'Having trouble resetting root password on my Linode',
                'volume_id'         => null,
            ],
        ];

        $response = <<<'JSON'
                        {
                            "id": 11223344,
                            "attachments": [
                                "screenshot.jpg",
                                "screenshot.txt"
                            ],
                            "closed": "2015-06-04T16:07:03",
                            "closable": false,
                            "description": "I'm having trouble setting the root password on my Linode. I tried following the instructions but something is not working and I'm not sure what I'm doing wrong. Can you please help me figure out how I can reset it?\n",
                            "entity": {
                                "id": 10400,
                                "label": "linode123456",
                                "type": "linode",
                                "url": "/v4/linode/instances/123456"
                            },
                            "gravatar_id": "474a1b7373ae0be4132649e69c36ce30",
                            "opened": "2015-06-04T14:16:44",
                            "opened_by": "some_user",
                            "status": "open",
                            "summary": "Having trouble resetting root password on my Linode\n",
                            "updated": "2015-06-04T16:07:03",
                            "updated_by": "some_other_user"
                        }
            JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/support/tickets', $request, new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $entity = $repository->open([
            SupportTicket::FIELD_DESCRIPTION       => 'I\'m having trouble setting the root password on my Linode. I tried following the instructions but something is not working and I\'m not sure what I\'m doing wrong. Can you please help me figure out how I can reset it?',
            SupportTicket::FIELD_DOMAIN_ID         => null,
            SupportTicket::FIELD_LINODE_ID         => 123,
            SupportTicket::FIELD_LONGVIEWCLIENT_ID => null,
            SupportTicket::FIELD_NODEBALANCER_ID   => null,
            SupportTicket::FIELD_SUMMARY           => 'Having trouble resetting root password on my Linode',
            SupportTicket::FIELD_VOLUME_ID         => null,
        ]);

        self::assertInstanceOf(SupportTicket::class, $entity);
        self::assertSame(11223344, $entity->id);
        self::assertSame("Having trouble resetting root password on my Linode\n", $entity->summary);
    }

    public function testClose(): void
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/support/tickets/11223344/close', [], new Response(200, [], null)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $repository->close(11223344);

        self::assertTrue(true);
    }

    public function testGetBaseUri(): void
    {
        $expected = '/support/tickets';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields(): void
    {
        $expected = [
            'id',
            'summary',
            'opened_by',
            'opened',
            'description',
            'gravatar_id',
            'status',
            'closable',
            'updated_by',
            'updated',
            'closed',
            'domain_id',
            'linode_id',
            'longviewclient_id',
            'nodebalancer_id',
            'volume_id',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity(): void
    {
        self::assertInstanceOf(SupportTicket::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): SupportTicketRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new SupportTicketRepository($linodeClient);
    }
}
