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
use Linode\Entity\Kernel;

/**
 * Kernel repository.
 */
class KernelRepository extends AbstractRepository
{
    // Available fields.
    public const FIELD_ID           = 'id';
    public const FIELD_LABEL        = 'label';
    public const FIELD_VERSION      = 'version';
    public const FIELD_ARCHITECTURE = 'architecture';
    public const FIELD_KVM          = 'kvm';
    public const FIELD_XEN          = 'xen';
    public const FIELD_PVOPS        = 'pvops';

    /**
     * {@inheritdoc}
     */
    public function __construct(string $access_token = null)
    {
        parent::__construct($access_token);

        $this->base_uri .= '/linode/kernels';
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedFields(): array
    {
        return [
            self::FIELD_ID,
            self::FIELD_LABEL,
            self::FIELD_VERSION,
            self::FIELD_ARCHITECTURE,
            self::FIELD_KVM,
            self::FIELD_XEN,
            self::FIELD_PVOPS,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function jsonToEntity(array $json): Entity
    {
        return new Kernel($json);
    }
}
