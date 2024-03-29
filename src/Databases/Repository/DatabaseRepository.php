<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Databases\Repository;

use Linode\Databases\Database;
use Linode\Databases\DatabaseRepositoryInterface;
use Linode\Entity;
use Linode\Internal\AbstractRepository;

/**
 * @codeCoverageIgnore This class was autogenerated.
 */
class DatabaseRepository extends AbstractRepository implements DatabaseRepositoryInterface
{
    protected function getBaseUri(): string
    {
        return 'beta/databases/instances';
    }

    protected function getSupportedFields(): array
    {
        return [
            Database::FIELD_ID,
            Database::FIELD_LABEL,
            Database::FIELD_REGION,
            Database::FIELD_TYPE,
            Database::FIELD_CLUSTER_SIZE,
            Database::FIELD_ENGINE,
            Database::FIELD_VERSION,
            Database::FIELD_STATUS,
            Database::FIELD_ENCRYPTED,
            Database::FIELD_ALLOW_LIST,
            Database::FIELD_HOSTS,
            Database::FIELD_CREATED,
            Database::FIELD_UPDATED,
            Database::FIELD_UPDATES,
            Database::FIELD_INSTANCE_URI,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new Database($this->client, $json);
    }
}
