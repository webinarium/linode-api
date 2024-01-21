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
use Linode\Entity\Managed\ManagedLinodeSettings;
use Linode\Internal\AbstractRepository;
use Linode\Repository\Managed\ManagedLinodeSettingsRepositoryInterface;

/**
 * {@inheritdoc}
 */
class ManagedLinodeSettingsRepository extends AbstractRepository implements ManagedLinodeSettingsRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function update(int $id, array $parameters): ManagedLinodeSettings
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_PUT, sprintf('%s/%s', $this->getBaseUri(), $id), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new ManagedLinodeSettings($this->client, $json);
    }

    /**
     * {@inheritdoc}
     */
    protected function getBaseUri(): string
    {
        return '/managed/linode-settings';
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedFields(): array
    {
        return [
            ManagedLinodeSettings::FIELD_ID,
            ManagedLinodeSettings::FIELD_LABEL,
            ManagedLinodeSettings::FIELD_GROUP,
            ManagedLinodeSettings::FIELD_SSH,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function jsonToEntity(array $json): Entity
    {
        return new ManagedLinodeSettings($this->client, $json);
    }
}
