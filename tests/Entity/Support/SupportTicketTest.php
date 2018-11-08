<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity\Support;

use Linode\Entity\LinodeEntity;
use Linode\Internal\Support\SupportTicketReplyRepository;
use Linode\LinodeClient;
use PHPUnit\Framework\TestCase;

class SupportTicketTest extends TestCase
{
    protected $client;

    protected function setUp()
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties()
    {
        $data = [
            'id'          => 11223344,
            'attachments' => [
                'screenshot.jpg',
                'screenshot.txt',
            ],
            'closed'      => '2015-06-04T16:07:03',
            'closable'    => false,
            'description' => "I'm having trouble setting the root password on my Linode. I tried following the instructions but something is not working and I'm not sure what I'm doing wrong. Can you please help me figure out how I can reset it?",
            'entity'      => [
                'id'    => 10400,
                'label' => 'linode123456',
                'type'  => 'linode',
                'url'   => '/v4/linode/instances/123456',
            ],
            'gravatar_id' => '474a1b7373ae0be4132649e69c36ce30',
            'opened'      => '2015-06-04T14:16:44',
            'opened_by'   => 'some_user',
            'status'      => 'open',
            'summary'     => 'Having trouble resetting root password on my Linode',
            'updated'     => '2015-06-04T16:07:03',
            'updated_by'  => 'some_other_user',
        ];

        $entity = new SupportTicket($this->client, $data);

        self::assertInstanceOf(LinodeEntity::class, $entity->entity);
        self::assertSame('linode123456', $entity->entity->label);

        self::assertInstanceOf(SupportTicketReplyRepository::class, $entity->replies);
    }
}
