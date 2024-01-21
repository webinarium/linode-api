<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal\Linode;

use Linode\Entity\Entity;
use Linode\Entity\Linode\ConfigurationProfile;
use Linode\Internal\AbstractRepository;
use Linode\LinodeClient;
use Linode\Repository\Linode\ConfigurationProfileRepositoryInterface;

/**
 * {@inheritdoc}
 */
class ConfigurationProfileRepository extends AbstractRepository implements ConfigurationProfileRepositoryInterface
{
    /**
     * {@inheritdoc}
     *
     * @param int $linodeId The ID of the Linode whose Configuration profile to look up
     */
    public function __construct(LinodeClient $client, protected int $linodeId)
    {
        parent::__construct($client);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $parameters): ConfigurationProfile
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_POST, $this->getBaseUri(), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new ConfigurationProfile($this->client, $json);
    }

    /**
     * {@inheritdoc}
     */
    public function update(int $id, array $parameters): ConfigurationProfile
    {
        $this->checkParametersSupport($parameters);

        $response = $this->client->api($this->client::REQUEST_PUT, sprintf('%s/%s', $this->getBaseUri(), $id), $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new ConfigurationProfile($this->client, $json);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(int $id): void
    {
        $this->client->api($this->client::REQUEST_DELETE, sprintf('%s/%s', $this->getBaseUri(), $id));
    }

    /**
     * {@inheritdoc}
     */
    protected function getBaseUri(): string
    {
        return sprintf('/linode/instances/%s/configs', $this->linodeId);
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedFields(): array
    {
        return [
            ConfigurationProfile::FIELD_ID,
            ConfigurationProfile::FIELD_LABEL,
            ConfigurationProfile::FIELD_KERNEL,
            ConfigurationProfile::FIELD_COMMENTS,
            ConfigurationProfile::FIELD_MEMORY_LIMIT,
            ConfigurationProfile::FIELD_RUN_LEVEL,
            ConfigurationProfile::FIELD_VIRT_MODE,
            ConfigurationProfile::FIELD_HELPERS,
            ConfigurationProfile::FIELD_DEVICES,
            ConfigurationProfile::FIELD_ROOT_DEVICE,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function jsonToEntity(array $json): Entity
    {
        return new ConfigurationProfile($this->client, $json);
    }
}
