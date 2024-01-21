<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Repository\Profile;

use Linode\Exception\LinodeException;
use Linode\Repository\RepositoryInterface;

/**
 * Trusted device repository.
 */
interface TrustedDeviceRepositoryInterface extends RepositoryInterface
{
    /**
     * @throws LinodeException
     */
    public function revoke(int $id): void;
}
