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
use Linode\Entity\Support\SupportTicket;
use Linode\Internal\AbstractRepository;
use Linode\Repository\Support\SupportTicketRepositoryInterface;

/**
 * {@inheritdoc}
 */
class SupportTicketRepository extends AbstractRepository implements SupportTicketRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function open(array $parameters): SupportTicket
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_POST, $this->getBaseUri(), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new SupportTicket($this->client, $json);
    }

    /**
     * {@inheritdoc}
     */
    public function close(int $id): void
    {
        $this->client->api($this->client::REQUEST_POST, sprintf('%s/%s/close', $this->getBaseUri(), $id));
    }

    /**
     * {@inheritdoc}
     */
    protected function getBaseUri(): string
    {
        return '/support/tickets';
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedFields(): array
    {
        return [
            SupportTicket::FIELD_ID,
            SupportTicket::FIELD_SUMMARY,
            SupportTicket::FIELD_OPENED_BY,
            SupportTicket::FIELD_OPENED,
            SupportTicket::FIELD_DESCRIPTION,
            SupportTicket::FIELD_GRAVATAR_ID,
            SupportTicket::FIELD_STATUS,
            SupportTicket::FIELD_CLOSABLE,
            SupportTicket::FIELD_UPDATED_BY,
            SupportTicket::FIELD_UPDATED,
            SupportTicket::FIELD_CLOSED,
            SupportTicket::FIELD_DOMAIN_ID,
            SupportTicket::FIELD_LINODE_ID,
            SupportTicket::FIELD_LONGVIEWCLIENT_ID,
            SupportTicket::FIELD_NODEBALANCER_ID,
            SupportTicket::FIELD_VOLUME_ID,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function jsonToEntity(array $json): Entity
    {
        return new SupportTicket($this->client, $json);
    }
}
