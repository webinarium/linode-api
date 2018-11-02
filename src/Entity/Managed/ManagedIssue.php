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
 * An Issue that was detected with a service Linode is managing.
 *
 * @property int                $id       This Issue's unique ID.
 * @property string             $created  When this Issue was created. Issues are created in response to issues
 *                                        detected with Managed Services, so this is also when the Issue was
 *                                        detected.
 * @property int[]              $services An array of Managed Service IDs that were affected by this Issue.
 * @property ManagedIssueEntity $entity   The ticket this Managed Issue opened.
 */
class ManagedIssue extends Entity
{
    /**
     * {@inheritdoc}
     */
    public function __get(string $name)
    {
        if ($name === 'entity') {
            return new ManagedIssueEntity($this->client, $this->data['entity']);
        }

        return parent::__get($name);
    }
}
