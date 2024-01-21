<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Repository\Managed;

use Linode\Entity\Managed\ManagedLinodeSettings;
use Linode\Exception\LinodeException;
use Linode\Repository\RepositoryInterface;

/**
 * Managed Linode settings repository.
 */
interface ManagedLinodeSettingsRepositoryInterface extends RepositoryInterface
{
    /**
     * Updates a single Linode's Managed settings.
     *
     * @throws LinodeException
     */
    public function update(int $id, array $parameters): ManagedLinodeSettings;
}
