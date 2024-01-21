<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal\Managed;

use Linode\Entity\Entity;
use Linode\Entity\Managed\ManagedIssue;
use Linode\Internal\AbstractRepository;
use Linode\Repository\Managed\ManagedIssueRepositoryInterface;

class ManagedIssueRepository extends AbstractRepository implements ManagedIssueRepositoryInterface
{
    protected function getBaseUri(): string
    {
        return '/managed/issues';
    }

    protected function getSupportedFields(): array
    {
        return [];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new ManagedIssue($this->client, $json);
    }
}
