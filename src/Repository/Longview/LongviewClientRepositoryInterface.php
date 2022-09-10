<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Repository\Longview;

use Linode\Entity\Longview\LongviewClient;
use Linode\Repository\RepositoryInterface;

/**
 * Longview client repository.
 */
interface LongviewClientRepositoryInterface extends RepositoryInterface
{
    /**
     * Creates a Longview Client. This Client will not begin monitoring
     * the status of your server until you configure the Longview
     * Client application on your Linode using the returning `install_code`
     * and `api_key`.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function create(array $parameters): LongviewClient;

    /**
     * Updates a Longview Client. This cannot update how it monitors your
     * server; use the Longview Client application on your Linode for
     * monitoring configuration.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function update(int $id, array $parameters): LongviewClient;

    /**
     * Deletes a Longview Client from your Account.
     * This does not uninstall the Longview Client application for your
     * Linode - you must do that manually.
     *
     * WARNING! All information stored for this client will be lost.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function delete(int $id): void;
}
