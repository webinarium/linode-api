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

use Linode\Entity\Entity;
use Linode\Entity\Support\SupportTicketReply;
use Linode\Internal\AbstractRepository;
use Linode\LinodeClient;
use Linode\Repository\Support\SupportTicketReplyRepositoryInterface;

/**
 * {@inheritdoc}
 */
class SupportTicketReplyRepository extends AbstractRepository implements SupportTicketReplyRepositoryInterface
{
    /**
     * {@inheritdoc}
     *
     * @param int $ticketId The ID of the Support Ticket we are accessing Replies for
     */
    public function __construct(LinodeClient $client, protected int $ticketId)
    {
        parent::__construct($client);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $parameters): SupportTicketReply
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_POST, $this->getBaseUri(), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new SupportTicketReply($this->client, $json);
    }

    /**
     * {@inheritdoc}
     */
    protected function getBaseUri(): string
    {
        return sprintf('/support/tickets/%s/replies', $this->ticketId);
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedFields(): array
    {
        return [
            SupportTicketReply::FIELD_ID,
            SupportTicketReply::FIELD_CREATED_BY,
            SupportTicketReply::FIELD_CREATED,
            SupportTicketReply::FIELD_DESCRIPTION,
            SupportTicketReply::FIELD_GRAVATAR_ID,
            SupportTicketReply::FIELD_FROM_LINODE,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function jsonToEntity(array $json): Entity
    {
        return new SupportTicketReply($this->client, $json);
    }
}
