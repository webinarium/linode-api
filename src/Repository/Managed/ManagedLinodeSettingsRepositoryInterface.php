<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Repository\Managed;

use Linode\Entity\Managed\ManagedLinodeSettings;
use Linode\Repository\RepositoryInterface;

/**
 * Managed Linode settings repository.
 */
interface ManagedLinodeSettingsRepositoryInterface extends RepositoryInterface
{
    /**
     * Updates a single Linode's Managed settings.
     *
     * @param int   $id
     * @param array $parameters
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return ManagedLinodeSettings
     */
    public function update(int $id, array $parameters): ManagedLinodeSettings;
}
