<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Managed;

use Linode\Entity;

/**
 * A service that Linode is monitoring as part of your Managed services.
 * If issues are detected with this service, a ManagedIssue will be opened
 * and, optionally, Linode special forces will attempt to resolve the Issue.
 *
 * @property int         $id                 This Service's unique ID.
 * @property string      $status             The current status of this Service.
 * @property string      $service_type       How this Service is monitored.
 * @property string      $label              The label for this Service. This is for display purposes only.
 * @property string      $address            The URL at which this Service is monitored.
 * @property string      $consultation_group The group of ManagedContacts who should be notified or consulted
 *                                           with when an Issue is detected.
 * @property int         $timeout            How long to wait, in seconds, for a response before considering the
 *                                           Service to be down.
 * @property null|string $body               What to expect to find in the response body for the Service to be
 *                                           considered up.
 * @property null|string $notes              Any information relevant to the Service that Linode special forces
 *                                           should know when attempting to resolve Issues.
 * @property string      $region             The Region in which this Service is located. This is required if
 *                                           address is a private IP, and may not be set otherwise.
 * @property int[]       $credentials        An array of ManagedCredential IDs that should be used when attempting to
 *                                           resolve issues with this Service.
 * @property string      $created            When this Managed Service was created.
 * @property string      $updated            When this Managed Service was last updated.
 */
class ManagedService extends Entity
{
    // Available fields.
    public const FIELD_ID                 = 'id';
    public const FIELD_STATUS             = 'status';
    public const FIELD_SERVICE_TYPE       = 'service_type';
    public const FIELD_LABEL              = 'label';
    public const FIELD_ADDRESS            = 'address';
    public const FIELD_CONSULTATION_GROUP = 'consultation_group';
    public const FIELD_TIMEOUT            = 'timeout';
    public const FIELD_BODY               = 'body';
    public const FIELD_NOTES              = 'notes';
    public const FIELD_REGION             = 'region';
    public const FIELD_CREDENTIALS        = 'credentials';

    // `FIELD_STATUS` values.
    public const STATUS_DISABLED = 'disabled';
    public const STATUS_PENDING  = 'pending';
    public const STATUS_OK       = 'ok';
    public const STATUS_PROBLEM  = 'problem';

    // `FIELD_SERVICE_TYPE` values.
    public const SERVICE_TYPE_URL = 'URL';
    public const SERVICE_TYPE_TCP = 'TCP';
}
