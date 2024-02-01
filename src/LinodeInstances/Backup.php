<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\LinodeInstances;

use Linode\Entity;

/**
 * An object representing a Backup or snapshot for a Linode with Backup service
 * enabled.
 *
 * @property int          $id       The unique ID of this Backup.
 * @property string       $status   The current state of a specific Backup.
 * @property string       $type     This indicates whether the Backup is an automatic Backup or manual snapshot taken
 *                                  by the User at a specific point in time.
 * @property string       $created  The date the Backup was taken.
 * @property string       $updated  The date the Backup was most recently updated.
 * @property string       $finished The date the Backup completed.
 * @property null|string  $label    A label for Backups that are of type `snapshot`.
 * @property string[]     $configs  A list of the labels of the Configuration profiles that are part of the Backup.
 * @property BackupDisk[] $disks    A list of the disks that are part of the Backup.
 */
class Backup extends Entity
{
    // Available fields.
    public const FIELD_ID       = 'id';
    public const FIELD_STATUS   = 'status';
    public const FIELD_TYPE     = 'type';
    public const FIELD_CREATED  = 'created';
    public const FIELD_UPDATED  = 'updated';
    public const FIELD_FINISHED = 'finished';
    public const FIELD_LABEL    = 'label';
    public const FIELD_CONFIGS  = 'configs';
    public const FIELD_DISKS    = 'disks';

    // `FIELD_STATUS` values.
    public const STATUS_PAUSED              = 'paused';
    public const STATUS_PENDING             = 'pending';
    public const STATUS_RUNNING             = 'running';
    public const STATUS_NEEDSPOSTPROCESSING = 'needsPostProcessing';
    public const STATUS_SUCCESSFUL          = 'successful';
    public const STATUS_FAILED              = 'failed';
    public const STATUS_USERABORTED         = 'userAborted';

    // `FIELD_TYPE` values.
    public const TYPE_AUTO     = 'auto';
    public const TYPE_SNAPSHOT = 'snapshot';

    /**
     * @codeCoverageIgnore This method was autogenerated.
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            self::FIELD_DISKS => array_map(fn ($data) => new BackupDisk($this->client, $data), $this->data[$name]),
            default           => parent::__get($name),
        };
    }
}