<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity\Account;

use Linode\Entity\Entity;
use Linode\Entity\LinodeEntity;

/**
 * An important, often time-sensitive item related to your Account.
 *
 * @property string       $label    A short description of this Notification.
 * @property string       $message  A human-readable description of the Notification.
 * @property string       $severity The severity of this Notification. This field can be used to
 *                                  decide how prominently to display the Notification, what color
 *                                  to make the display text, etc (@see `SEVERITY_...` constants).
 * @property string       $when     If this Notification is of an Event that will happen at a fixed,
 *                                  future time, this is when the named action will be taken. For
 *                                  example, if a Linode is to be migrated in response to a
 *                                  Security Advisory, this field will contain the approximate time the
 *                                  Linode will be taken offline for migration.
 * @property string       $until    If this Notification has a duration, this will be the ending time
 *                                  for the Event/action. For example, if there is scheduled
 *                                  maintenance for one of our systems, `until` would be set to the end
 *                                  of the maintenance window.
 * @property string       $type     The type of Notification this is (@see `TYPE_...` constants).
 * @property LinodeEntity $entity   Detailed information about the Notification.
 */
class Notification extends Entity
{
    // Available fields.
    public const FIELD_LABEL    = 'label';
    public const FIELD_MESSAGE  = 'message';
    public const FIELD_SEVERITY = 'severity';
    public const FIELD_WHEN     = 'when';
    public const FIELD_UNTIL    = 'until';
    public const FIELD_TYPE     = 'type';

    // Notification types.
    public const TYPE_MIGRATION_SCHEDULED = 'migration_scheduled';
    public const TYPE_MIGRATION_PENDING   = 'migration_pending';
    public const TYPE_REBOOT_SCHEDULED    = 'reboot_scheduled';
    public const TYPE_OUTAGE              = 'outage';
    public const TYPE_PAYMENT_DUE         = 'payment_due';
    public const TYPE_TICKET_IMPORTANT    = 'ticket_important';
    public const TYPE_TICKET_ABUSE        = 'ticket_abuse';
    public const TYPE_NOTICE              = 'notice';

    // Notification severities.
    public const SEVERITY_MINOR    = 'minor';
    public const SEVERITY_MAJOR    = 'major';
    public const SEVERITY_CRITICAL = 'critical';

    /**
     * {@inheritdoc}
     */
    public function __get(string $name)
    {
        if ($name === 'entity') {
            return new LinodeEntity($this->client, $this->data['entity']);
        }

        return parent::__get($name);
    }
}
