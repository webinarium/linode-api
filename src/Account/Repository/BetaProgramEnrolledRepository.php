<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Account\Repository;

use Linode\Account\BetaProgramEnrolled;
use Linode\Account\BetaProgramEnrolledRepositoryInterface;
use Linode\Entity;
use Linode\Internal\AbstractRepository;

/**
 * @codeCoverageIgnore This class was autogenerated.
 */
class BetaProgramEnrolledRepository extends AbstractRepository implements BetaProgramEnrolledRepositoryInterface
{
    public function enrollBetaProgram(array $parameters = []): void
    {
        $this->client->post($this->getBaseUri(), $parameters);
    }

    protected function getBaseUri(): string
    {
        return '/account/betas';
    }

    protected function getSupportedFields(): array
    {
        return [
            BetaProgramEnrolled::FIELD_ID,
            BetaProgramEnrolled::FIELD_LABEL,
            BetaProgramEnrolled::FIELD_DESCRIPTION,
            BetaProgramEnrolled::FIELD_STARTED,
            BetaProgramEnrolled::FIELD_ENDED,
            BetaProgramEnrolled::FIELD_ENROLLED,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new BetaProgramEnrolled($this->client, $json);
    }
}
