<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Repository;

use Linode\Entity\Entity;
use Linode\Entity\LinodeType;

/**
 * Linode type repository.
 */
class LinodeTypeRepository extends AbstractRepository
{
    // Available fields.
    public const FIELD_ID          = 'id';
    public const FIELD_LABEL       = 'label';
    public const FIELD_CLASS       = 'class';
    public const FIELD_DISK        = 'disk';
    public const FIELD_MEMORY      = 'memory';
    public const FIELD_VCPLUS      = 'vcpus';
    public const FIELD_NETWORK_OUT = 'network_out';
    public const FIELD_TRANSFER    = 'transfer';

    /**
     * {@inheritdoc}
     */
    public function __construct(string $access_token = null)
    {
        parent::__construct($access_token);

        $this->base_uri .= '/linode/types';
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedFields(): array
    {
        return [
            self::FIELD_ID,
            self::FIELD_LABEL,
            self::FIELD_CLASS,
            self::FIELD_DISK,
            self::FIELD_MEMORY,
            self::FIELD_VCPLUS,
            self::FIELD_NETWORK_OUT,
            self::FIELD_TRANSFER,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function jsonToEntity(array $json): Entity
    {
        return new LinodeType($json);
    }
}
