<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity\Linode;

use Linode\Entity\Entity;

/**
 * An object representing a Backup or snapshot for a Linode with Backup service enabled.
 *
 * @property int                $id       The unique ID of this Backup.
 * @property string             $status   The current state of a specific Backup (@see `STATUS_...` constants).
 * @property string             $type     This indicates whether the Backup is an automatic Backup or
 *                                        manual snapshot taken by the User at a specific point in time
 *                                        (@see `Disk::TYPE_...` constants).
 * @property string             $created  The date the Backup was taken.
 * @property string             $updated  The date the Backup was most recently updated.
 * @property string             $finished The date the Backup completed.
 * @property string             $label    A label for Backups that are of type `snapshot`.
 * @property string[]           $configs  A list of the labels of the Configuration profiles that are part
 *                                        of the Backup.
 * @property array|BackupDisk[] $disks    A list of the disks that are part of the Backup.
 */
class Backup extends Entity
{
    // Backup statuses.
    public const STATUS_PAUSED                = 'paused';
    public const STATUS_PENDING               = 'pending';
    public const STATUS_RUNNING               = 'running';
    public const STATUS_NEEDS_POST_PROCESSING = 'needsPostProcessing';
    public const STATUS_SUCCESSFUL            = 'successful';
    public const STATUS_FAILED                = 'failed';
    public const STATUS_USER_ABORTED          = 'userAborted';

    // Backup types.
    public const TYPE_AUTO     = 'auto';
    public const TYPE_SNAPSHOT = 'snapshot';

    /**
     * {@inheritdoc}
     */
    public function __get(string $name)
    {
        if ($name === 'disks') {
            return array_map(function ($data) {
                return new BackupDisk($this->client, $data);
            }, $this->data[$name]);
        }

        return parent::__get($name);
    }
}
