<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity\Managed;

use Linode\Entity\Entity;

/**
 * Settings for a specific Linode related to Managed Services. There is
 * one ManagedLinodeSettings object for each Linode on your Account.
 *
 * @property int         $id    The ID of the Linode these Settings are for.
 * @property string      $label The label of the Linode these Settings are for.
 * @property string      $group The group of the Linode these Settings are for. This is for display
 *                              purposes only.
 * @property SSHSettings $ssh   The SSH settings for this Linode.
 */
class ManagedLinodeSettings extends Entity
{
    // Available fields.
    public const FIELD_ID    = 'id';
    public const FIELD_LABEL = 'label';
    public const FIELD_GROUP = 'group';
    public const FIELD_SSH   = 'ssh';

    /**
     * {@inheritdoc}
     */
    public function __get(string $name)
    {
        if ($name === self::FIELD_SSH) {
            return new SSHSettings($this->client, $this->data[self::FIELD_SSH]);
        }

        return parent::__get($name);
    }
}
