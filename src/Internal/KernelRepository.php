<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal;

use Linode\Entity\Entity;
use Linode\Entity\Kernel;
use Linode\Repository\KernelRepositoryInterface;

class KernelRepository extends AbstractRepository implements KernelRepositoryInterface
{
    protected function getBaseUri(): string
    {
        return '/linode/kernels';
    }

    protected function getSupportedFields(): array
    {
        return [
            Kernel::FIELD_ID,
            Kernel::FIELD_LABEL,
            Kernel::FIELD_VERSION,
            Kernel::FIELD_ARCHITECTURE,
            Kernel::FIELD_KVM,
            Kernel::FIELD_XEN,
            Kernel::FIELD_PVOPS,
        ];
    }

    protected function jsonToEntity(array $json): Entity
    {
        return new Kernel($this->client, $json);
    }
}
